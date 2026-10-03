# React Resume Website

## Project content

Each portfolio project owns its content in a top-level repository directory:

```text
Example_Project/
  project.json
  README.md
  portfolio-thumbnail.jpg
  Presentation/
    Home.png
```

Add a `project.json` to publish a project; no React changes or central project list are needed:

```json
{
  "title": "Example Project",
  "category": "Web Development",
  "date": "Oct. 2026",
  "description": "A short summary for the project card.",
  "thumbnail": "portfolio-thumbnail.jpg",
  "order": 17,
  "publicFiles": ["report.html"]
}
```

All fields except `publicFiles` are required. Lower `order` values appear first; ties sort by directory name. Thumbnail and optional public-file paths are relative to the project directory and must point to existing files. Omit `publicFiles` when there are no additional downloads or reports. HTML reports remain available at `/My-Projects/<directory>/<filename>`; list any external local files they need as well.

The directory name determines the existing `#project/<key>` route: punctuation is removed and letters are lowercased (`PetVetMaster.API` becomes `petvetmasterapi`). Keep the directory name to preserve links. Directory names and asset references must match filename casing exactly.

Write README image references relative to that README, for example `![Home](Presentation/Home.png)`. Encode spaces as `%20`, or enclose the destination in angle brackets. Repository-root paths and `../` references within the repository also work. Markdown reference images and sanitized HTML `<img>` elements are supported. Commented-out content stays hidden. Unreferenced images are not published as galleries. External image URLs remain external, and GitHub `blob` image URLs are converted to raw image URLs.

Only the source project directories are maintained. The Vite plugin discovers metadata and generates `project-catalog.json`, READMEs, thumbnails, visible referenced images, and `publicFiles`. Development serves these in memory and reloads on changes; production writes them into the ignored `build/` directory. Never copy project content into `React_Website/public`. Site-wide text and repository settings remain in `public/resumeData.json`.

Ordinary relative README links open the corresponding GitHub source. Links to files listed in that project's `publicFiles` open the published file. The README and images shown on the site come from the same deployment; pushing project changes to `main` triggers the existing GitHub Pages workflow.

## Development and validation

```sh
npm ci --legacy-peer-deps
npm start
npm run validate:readmes
npm run test:projects
npm run test:contact
npm run build
```

Validation fails on missing or incorrectly cased assets, invalid metadata, duplicate route keys, or duplicate public assets. Tests cover path resolution, HTML sanitization, project discovery, and development regeneration. The deployment workflow runs the tests and validation before publishing.
