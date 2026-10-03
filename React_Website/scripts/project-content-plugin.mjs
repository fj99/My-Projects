import path from "node:path";
import fs from "node:fs";
import { defaultRepoRoot, generateProjectCatalog, readGeneratedFile } from "./project-catalog.mjs";

const contentTypes = {
  ".json": "application/json", ".md": "text/plain", ".html": "text/html",
  ".png": "image/png", ".jpg": "image/jpeg", ".jpeg": "image/jpeg",
  ".gif": "image/gif", ".webp": "image/webp", ".svg": "image/svg+xml", ".avif": "image/avif",
};

export default function projectContentPlugin({ repoRoot = defaultRepoRoot } = {}) {
  let catalog;
  let config;
  let generationError;
  return {
    name: "project-directory-content",
    configResolved(resolved) { config = resolved; },
    buildStart() {
      catalog = generateProjectCatalog({ repoRoot });
      for (const file of catalog.watchedFiles) this.addWatchFile(file);
    },
    generateBundle() {
      for (const [fileName, file] of catalog.files) {
        this.emitFile({ type: "asset", fileName, source: readGeneratedFile(file) });
      }
    },
    configureServer(server) {
      catalog = generateProjectCatalog({ repoRoot });
      // Shallow directory watches also see files created after a failed build.
      // Watching a missing filename alone can miss its initial creation.
      let timer;
      const metadataWatchers = new Map();
      const contentWatchers = new Map();
      const syncContentWatchers = (files) => {
        const targets = new Map();
        for (const file of files) {
          let directory = path.dirname(file);
          while (!fs.existsSync(directory)) directory = path.dirname(directory);
          if (!targets.has(directory)) targets.set(directory, new Set());
          targets.get(directory).add(path.normalize(file));
        }
        for (const [directory, entry] of contentWatchers) {
          if (!targets.has(directory)) { entry.watcher.close(); contentWatchers.delete(directory); }
        }
        for (const [directory, filesInDirectory] of targets) {
          if (contentWatchers.has(directory)) {
            contentWatchers.get(directory).files = filesInDirectory;
          } else {
            const entry = { files: filesInDirectory };
            entry.watcher = fs.watch(directory, { persistent: false }, (_event, filename) => {
              const changed = filename ? path.join(directory, String(filename)) : null;
              if (!changed || [...entry.files].some((file) => file === changed || file.startsWith(changed + path.sep))) schedule();
            });
            contentWatchers.set(directory, entry);
          }
        }
      };
      const syncMetadataWatchers = () => {
        const directories = new Set(fs.readdirSync(repoRoot, { withFileTypes: true })
          .filter((entry) => entry.isDirectory() && !entry.name.startsWith(".") && !["React_Website", "node_modules"].includes(entry.name))
          .map((entry) => entry.name));
        for (const [directory, watcher] of metadataWatchers) {
          if (!directories.has(directory)) { watcher.close(); metadataWatchers.delete(directory); }
        }
        for (const directory of directories) {
          if (!metadataWatchers.has(directory)) {
            metadataWatchers.set(directory, fs.watch(path.join(repoRoot, directory), { persistent: false }, (_event, filename) => {
              if (!filename || String(filename) === "project.json") schedule();
            }));
          }
        }
      };
      const schedule = () => {
        clearTimeout(timer);
        timer = setTimeout(() => {
          try {
            syncMetadataWatchers();
            catalog = generateProjectCatalog({ repoRoot });
            generationError = null;
            syncContentWatchers(catalog.watchedFiles);
            server.ws.send({ type: "full-reload" });
          } catch (error) {
            generationError = error;
            if (error.watchedFiles) syncContentWatchers(error.watchedFiles);
            server.config.logger.error(error.message);
            server.ws.send({ type: "error", err: { message: error.message, stack: "", plugin: "project-directory-content" } });
          }
        }, 100);
      };
      syncMetadataWatchers();
      syncContentWatchers(catalog.watchedFiles);
      const rootWatcher = fs.watch(repoRoot, { persistent: false }, (_event, filename) => {
        if (!filename || (!String(filename).startsWith(".") && !["React_Website", "node_modules"].includes(String(filename)))) schedule();
      });
      server.httpServer?.once("close", () => {
        clearTimeout(timer);
        rootWatcher.close();
        for (const watcher of metadataWatchers.values()) watcher.close();
        for (const entry of contentWatchers.values()) entry.watcher.close();
      });
      server.middlewares.use((req, res, next) => {
        let requested;
        try { requested = decodeURIComponent(new URL(req.url, "http://localhost").pathname); }
        catch { res.statusCode = 400; res.end("Invalid asset path"); return; }
        const base = decodeURIComponent(config.base);
        const name = (requested.startsWith(base) ? requested.slice(base.length) : requested.replace(/^\//, ""));
        const file = catalog.files.get(name);
        if (!file) { next(); return; }
        if (generationError) { res.statusCode = 500; res.end(generationError.message); return; }
        res.setHeader("Content-Type", contentTypes[path.extname(name).toLowerCase()] || "application/octet-stream");
        res.setHeader("Cache-Control", "no-store");
        try { res.end(readGeneratedFile(file)); }
        catch { res.statusCode = 404; res.end("Project asset not found"); }
      });
    },
  };
}
