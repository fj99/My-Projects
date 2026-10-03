import fs from "node:fs";
import path from "node:path";
import { defaultRepoRoot, generateProjectCatalog } from "./project-catalog.mjs";

try {
  const settings = JSON.parse(fs.readFileSync(path.join(defaultRepoRoot, "React_Website/public/resumeData.json"), "utf8"));
  for (const field of ["owner", "name", "branch"]) {
    if (!settings.portfolio?.repository?.[field]) throw new Error(`portfolio.repository.${field} is required`);
  }
  if (settings.portfolio.projects) throw new Error("Project details belong in project directories, not resumeData.json");
  const { projects, files } = generateProjectCatalog();
  console.log(`[project-content] Validated ${projects.length} projects and ${files.size - 1} published files from their original directories.`);
} catch (error) {
  console.error(error.message);
  process.exitCode = 1;
}
