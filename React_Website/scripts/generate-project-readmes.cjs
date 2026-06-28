const fs = require("fs");
const path = require("path");

const siteRoot = path.resolve(__dirname, "..");
const repoRoot = path.resolve(siteRoot, "..");
const resumeDataPath = path.join(siteRoot, "public", "resumeData.json");
const outputDir = path.join(siteRoot, "src", "generated");
const outputPath = path.join(outputDir, "projectReadmes.json");
const ignoredRootFolders = new Set([
  ".git",
  ".vscode",
  "node_modules",
  "OldResumes",
  "React_Website",
]);

function normalize(value) {
  return String(value || "")
    .replace(/README\.md$/i, "")
    .replace(/[\\/]+$/g, "")
    .replace(/[^a-z0-9]/gi, "")
    .toLowerCase();
}

function getProjectFolderFromUrl(url) {
  return String(url || "")
    .split(/[?#]/)[0]
    .replace(/^\.?\//, "")
    .split("/")[0];
}

function indexFolders(baseDir, exclude = new Set()) {
  const folders = new Map();
  if (!fs.existsSync(baseDir)) {
    return folders;
  }

  for (const entry of fs.readdirSync(baseDir, { withFileTypes: true })) {
    if (!entry.isDirectory() || exclude.has(entry.name)) {
      continue;
    }

    const folderPath = path.join(baseDir, entry.name);
    const readmePath = path.join(folderPath, "README.md");
    if (fs.existsSync(readmePath)) {
      folders.set(normalize(entry.name), {
        folder: entry.name,
        folderPath,
        readmePath,
        source: path.relative(siteRoot, folderPath).replace(/\\/g, "/"),
      });
    }
  }

  return folders;
}

const resumeData = JSON.parse(fs.readFileSync(resumeDataPath, "utf8"));
const rootFolders = indexFolders(repoRoot, ignoredRootFolders);
const publicFolders = indexFolders(path.join(siteRoot, "public"));

const projects = {};
const warnings = [];

for (const project of resumeData.portfolio.projects) {
  const configuredFolder = getProjectFolderFromUrl(project.url);
  const key = normalize(configuredFolder || project.title);
  const source = rootFolders.get(key) || publicFolders.get(key);

  if (!source) {
    warnings.push(`No README.md found for "${project.title}" (${project.url})`);
    continue;
  }

  projects[key] = {
    key,
    title: project.title,
    folder: source.folder,
    source: source.source,
    markdown: fs.readFileSync(source.readmePath, "utf8"),
  };
}

fs.mkdirSync(outputDir, { recursive: true });
fs.writeFileSync(
  outputPath,
  `${JSON.stringify({ generatedAt: new Date().toISOString(), projects, warnings }, null, 2)}\n`
);

for (const warning of warnings) {
  console.warn(`[project-readmes] ${warning}`);
}

console.log(
  `[project-readmes] Generated ${Object.keys(projects).length} project README entries.`
);
