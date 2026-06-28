const fs = require("fs");
const path = require("path");

const siteRoot = path.resolve(__dirname, "..");
const buildProjectsDir = path.join(siteRoot, "build", "projects");
const manifestPath = path.join(siteRoot, "src", "generated", "projectReadmes.json");

if (!fs.existsSync(manifestPath)) {
  throw new Error("Missing project README manifest. Run generate-project-readmes first.");
}

const manifest = JSON.parse(fs.readFileSync(manifestPath, "utf8"));

fs.rmSync(buildProjectsDir, { recursive: true, force: true });
fs.mkdirSync(buildProjectsDir, { recursive: true });

for (const project of Object.values(manifest.projects)) {
  const sourcePath = path.resolve(siteRoot, project.source);
  const targetPath = path.join(buildProjectsDir, project.folder);
  fs.cpSync(sourcePath, targetPath, {
    recursive: true,
    filter(source) {
      const name = path.basename(source);
      return name !== "node_modules" && name !== ".git";
    },
  });
}

console.log(
  `[project-readmes] Copied ${Object.keys(manifest.projects).length} project folders into build/projects.`
);
