import fs from "node:fs";
import path from "node:path";
import { fileURLToPath } from "node:url";
import { encodeRepositoryPath, getProjectReadmeKey, readmeImageSources, resolveRepositoryPath } from "../src/projectContent.js";

export const defaultRepoRoot = fileURLToPath(new URL("../../", import.meta.url));

function assertFile(repoRoot, relativePath) {
  let current = repoRoot;
  for (const segment of relativePath.split("/")) {
    if (!segment || segment === "." || segment === ".." || !fs.readdirSync(current).includes(segment)) {
      throw new Error(`Missing file or incorrect filename casing: ${relativePath}`);
    }
    current = path.join(current, segment);
    if (fs.lstatSync(current).isSymbolicLink()) throw new Error(`Symbolic links cannot be published: ${relativePath}`);
  }
  if (!fs.statSync(current).isFile()) throw new Error(`Expected a file: ${relativePath}`);
  return current;
}

export function generateProjectCatalog({ repoRoot = defaultRepoRoot } = {}) {
  const projects = [];
  const files = new Map();
  const watchedFiles = new Set();
  const keys = new Set();
  const errors = [];
  const publicRoot = path.join(repoRoot, "React_Website/public");

  const addFile = (relativePath) => {
    watchedFiles.add(path.join(repoRoot, relativePath));
    if (relativePath.startsWith("React_Website/") || relativePath.split("/").some((part) => part.startsWith("."))) {
      throw new Error(`Project assets must live in project directories: ${relativePath}`);
    }
    const sourcePath = assertFile(repoRoot, relativePath);
    if (fs.existsSync(path.join(publicRoot, relativePath))) {
      throw new Error(`Remove the duplicate website asset: React_Website/public/${relativePath}`);
    }
    files.set(relativePath, { sourcePath });
    watchedFiles.add(sourcePath);
  };

  const directories = fs.readdirSync(repoRoot, { withFileTypes: true })
    .filter((entry) => entry.isDirectory() && !entry.name.startsWith(".") && entry.name !== "React_Website")
    .map((entry) => entry.name).sort();

  for (const directory of directories) {
    const metadataPath = path.join(repoRoot, directory, "project.json");
    if (!fs.existsSync(metadataPath)) continue;
    watchedFiles.add(metadataPath);
    try {
      assertFile(repoRoot, `${directory}/project.json`);
      const metadata = JSON.parse(fs.readFileSync(metadataPath, "utf8"));
      for (const field of ["title", "category", "date", "description", "thumbnail"]) {
        if (typeof metadata[field] !== "string" || !metadata[field].trim()) throw new Error(`project.json requires ${field}`);
      }
      if (!Number.isFinite(metadata.order)) throw new Error("project.json requires a numeric order");
      if (metadata.publicFiles !== undefined && (!Array.isArray(metadata.publicFiles) || metadata.publicFiles.some((file) => typeof file !== "string"))) {
        throw new Error("publicFiles must be a list of relative file paths");
      }
      const project = {
        title: metadata.title, category: metadata.category, date: metadata.date,
        description: metadata.description, order: metadata.order, url: `${directory}/`,
        publicFiles: metadata.publicFiles || [],
      };
      project.key = getProjectReadmeKey(project);
      if (!project.key || keys.has(project.key)) throw new Error(`Duplicate or empty project route key: ${project.key}`);
      keys.add(project.key);

      const ownedPath = (value) => {
        const resolved = resolveRepositoryPath(value, directory);
        if (!resolved || resolved.suffix || !resolved.path.startsWith(`${directory}/`)) {
          throw new Error(`Expected a file inside ${directory}: ${value}`);
        }
        return resolved.path;
      };
      const thumbnail = ownedPath(metadata.thumbnail);
      if (!/\.(png|jpe?g|gif|webp|svg|avif)$/i.test(thumbnail)) throw new Error(`Unsupported thumbnail: ${thumbnail}`);
      addFile(thumbnail);
      project.image = encodeRepositoryPath(thumbnail);
      project.readme = encodeRepositoryPath(`${directory}/README.md`);
      addFile(`${directory}/README.md`);
      const markdown = fs.readFileSync(files.get(`${directory}/README.md`).sourcePath, "utf8");
      for (const src of readmeImageSources(markdown)) {
        const local = resolveRepositoryPath(src, directory);
        if (local) addFile(local.path);
      }
      for (const file of project.publicFiles) addFile(ownedPath(file));
      projects.push(project);
    } catch (error) {
      errors.push(`${directory}: ${error.message}`);
    }
  }

  if (errors.length) {
    const error = new Error(`Project content validation failed:\n${errors.map((entry) => `- ${entry}`).join("\n")}`);
    error.watchedFiles = watchedFiles;
    throw error;
  }
  projects.sort((a, b) => a.order - b.order || a.url.localeCompare(b.url));
  files.set("project-catalog.json", { content: JSON.stringify({ projects }, null, 2) + "\n" });
  return { projects, files, watchedFiles };
}

export function readGeneratedFile(file) {
  return file.content === undefined ? fs.readFileSync(file.sourcePath) : file.content;
}
