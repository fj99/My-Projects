const fs = require("fs");
const path = require("path");

const siteRoot = path.resolve(__dirname, "..");
const repoRoot = path.resolve(siteRoot, "..");
const publicRoot = path.join(siteRoot, "public");
const resumeDataPath = path.join(publicRoot, "resumeData.json");
const resumeData = JSON.parse(fs.readFileSync(resumeDataPath, "utf8"));
const errors = [];

function isExternalUrl(url) {
  return /^(?:[a-z][a-z0-9+.-]*:|\/\/)/i.test(String(url || ""));
}

function getProjectFolder(url) {
  return String(url || "")
    .split(/[?#]/)[0]
    .replace(/^\.?\//, "")
    .replace(/\/+$/g, "")
    .split("/")[0];
}

function findReadmes(directory) {
  if (!fs.existsSync(directory)) {
    return [];
  }

  return fs.readdirSync(directory, { withFileTypes: true }).flatMap((entry) => {
    const entryPath = path.join(directory, entry.name);
    if (entry.isDirectory()) {
      return findReadmes(entryPath);
    }
    return entry.isFile() && entry.name.toLowerCase() === "readme.md" ? [entryPath] : [];
  });
}

const repository = resumeData.portfolio?.repository;
for (const field of ["owner", "name", "branch"]) {
  if (!repository?.[field]) {
    errors.push(`portfolio.repository.${field} is required.`);
  }
}

const rootDirectories = fs
  .readdirSync(repoRoot, { withFileTypes: true })
  .filter((entry) => entry.isDirectory())
  .map((entry) => entry.name);
const keys = new Set();
let localProjectCount = 0;

for (const project of resumeData.portfolio?.projects || []) {
  if (!project.url || isExternalUrl(project.url)) {
    continue;
  }

  localProjectCount += 1;
  const folder = getProjectFolder(project.url);
  const matchingFolder = rootDirectories.find(
    (directory) => directory.toLowerCase() === folder.toLowerCase()
  );

  if (!matchingFolder) {
    errors.push(`${project.title}: root project folder "${folder}" does not exist.`);
    continue;
  }

  if (matchingFolder !== folder) {
    errors.push(
      `${project.title}: configured folder "${folder}" must match root folder casing "${matchingFolder}".`
    );
  }

  const projectFiles = fs.readdirSync(path.join(repoRoot, matchingFolder), {
    withFileTypes: true,
  });
  if (!projectFiles.some((entry) => entry.isFile() && entry.name === "README.md")) {
    errors.push(`${project.title}: ${matchingFolder}/README.md is missing or incorrectly cased.`);
  }

  const key = folder.replace(/[^a-z0-9]/gi, "").toLowerCase();
  if (keys.has(key)) {
    errors.push(`${project.title}: duplicate README route key "${key}".`);
  }
  keys.add(key);
}

for (const readmePath of findReadmes(publicRoot)) {
  errors.push(
    `Duplicate public README found at ${path.relative(repoRoot, readmePath).replace(/\\/g, "/")}.`
  );
}

if (errors.length) {
  console.error("[project-readmes] Validation failed:\n");
  for (const error of errors) {
    console.error(`- ${error}`);
  }
  process.exit(1);
}

console.log(
  `[project-readmes] Validated ${localProjectCount} canonical project README files with no public duplicates.`
);
