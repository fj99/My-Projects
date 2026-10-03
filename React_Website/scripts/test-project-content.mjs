import assert from "node:assert/strict";
import fs from "node:fs";
import os from "node:os";
import path from "node:path";
import { test } from "node:test";
import { visit } from "unist-util-visit";
import { createServer } from "vite";
import { generateProjectCatalog } from "./project-catalog.mjs";
import projectContentPlugin from "./project-content-plugin.mjs";
import {
  getProjectReadmeKey, parseReadme, readmeImageSources, resolveReadmeImage,
  resolveReadmeLink, resolveRepositoryPath, rehypeProjectUrls,
} from "../src/projectContent.js";

const repository = { owner: "owner", name: "repo", branch: "main" };

function fixture(t) {
  const repoRoot = fs.mkdtempSync(path.join(os.tmpdir(), "project-catalog-test-"));
  t.after(() => {
    const resolved = path.resolve(repoRoot);
    if (path.dirname(resolved) !== path.resolve(os.tmpdir()) || !path.basename(resolved).startsWith("project-catalog-test-")) {
      throw new Error("Unsafe fixture cleanup path");
    }
    fs.rmSync(resolved, { recursive: true, force: true });
  });
  function write(relative, content = "image fixture") {
    const destination = path.join(repoRoot, relative);
    fs.mkdirSync(path.dirname(destination), { recursive: true });
    fs.writeFileSync(destination, content);
  }
  function project(directory = "Example", overrides = {}) {
    write(`${directory}/project.json`, JSON.stringify({
      title: directory, category: "Web Development", date: "Oct. 2026",
      description: "Project summary", thumbnail: "thumbnail.png", order: 0, ...overrides,
    }));
    write(`${directory}/thumbnail.png`);
    write(`${directory}/README.md`, "# Example\n\n![Screenshot](images/Screen%20One.png)\n");
    write(`${directory}/images/Screen One.png`);
  }
  return { repoRoot, write, project, generate: () => generateProjectCatalog({ repoRoot }) };
}

test("image paths handle spaces, nested paths, root paths, queries, and fragments", () => {
  assert.equal(resolveReadmeImage("./images/Screen%20One.png?raw=true#detail", "Example", "/My-Projects/"), "/My-Projects/Example/images/Screen%20One.png?raw=true#detail");
  assert.equal(resolveReadmeImage("../Shared/a b.png", "Example", "/My-Projects/"), "/My-Projects/Shared/a%20b.png");
  assert.equal(resolveReadmeImage("/Shared/a.png", "Example", "/My-Projects/"), "/My-Projects/Shared/a.png");
  assert.equal(resolveReadmeImage("images/100%25.png", "Example", "/"), "/Example/images/100%25.png");
  assert.throws(() => resolveRepositoryPath("../../private.png", "Example"), /escapes/);
});

test("external images stay external and GitHub blob images become raw URLs", () => {
  assert.equal(resolveReadmeImage("https://cdn.example.com/a.png?v=1", "Example", "/"), "https://cdn.example.com/a.png?v=1");
  assert.equal(resolveReadmeImage("https://github.com/owner/repo/blob/main/img/a%20b.png?raw=true", "Example", "/"), "https://raw.githubusercontent.com/owner/repo/main/img/a%20b.png");
  assert.equal(resolveReadmeImage("javascript:alert(1)", "Example", "/"), "");
  assert.equal(resolveReadmeImage("https://[invalid/image.png", "Example", "/"), "");
});

test("ordinary links use GitHub, published reports use the site, anchors remain anchors", () => {
  assert.equal(resolveReadmeLink("./src/main.js", "Example", repository, "/site/"), "https://github.com/owner/repo/blob/main/Example/src/main.js");
  assert.equal(resolveReadmeLink("/Shared/file.txt", "Example", repository, "/site/"), "https://github.com/owner/repo/blob/main/Shared/file.txt");
  assert.equal(resolveReadmeLink("report.html#chart", "Example", repository, "/site/", ["report.html"]), "/site/Example/report.html#chart");
  assert.equal(resolveReadmeLink("#details", "Example", repository, "/"), "#details");
});

test("Markdown references and HTML images render while comments, scripts, and handlers do not", () => {
  const markdown = `![First][screenshot]\n\n[screenshot]: images/one.png\n\n<img src="images/two.png" alt="Second" onerror="alert(1)">\n\n<!-- ![Hidden](missing.png) <img src="also-missing.png"> -->\n\n<script>alert(1)</script>\n\n<a href="javascript:alert(1)">Unsafe link</a>`;
  assert.deepEqual(readmeImageSources(markdown), ["images/one.png", "images/two.png"]);
  const tree = parseReadme(markdown);
  const tags = [];
  visit(tree, "element", (node) => {
    tags.push(node.tagName);
    assert.equal(node.properties.onError, undefined);
    assert.equal(node.properties.onerror, undefined);
    if (node.tagName === "a") assert.equal(node.properties.href, undefined);
  });
  assert.ok(!tags.includes("script"));
  rehypeProjectUrls({ directory: "Example", repository, baseUrl: "/site/" })(tree);
  const images = [];
  visit(tree, "element", (node) => { if (node.tagName === "img") images.push(node.properties.src); });
  assert.deepEqual(images, ["/site/Example/images/one.png", "/site/Example/images/two.png"]);
});

test("discovers new projects without website configuration and preserves ordering and route keys", (t) => {
  const f = fixture(t);
  f.project("Second_Project", { order: 2 });
  assert.equal(f.generate().projects.length, 1);
  f.project("First.Project", { order: 1 });
  const generated = f.generate();
  assert.deepEqual(generated.projects.map((p) => p.key), ["firstproject", "secondproject"]);
  assert.equal(getProjectReadmeKey({ url: "PetVetMaster.API/" }), "petvetmasterapi");
  assert.ok(generated.files.has("First.Project/images/Screen One.png"));
  assert.ok(!fs.existsSync(path.join(f.repoRoot, "React_Website")));
});

test("publishes only visible referenced images and explicitly listed reports", (t) => {
  const f = fixture(t);
  f.project("Example", { publicFiles: ["legacy.html"] });
  f.write("Example/README.md", "# Project\n<!-- ![Hidden](missing.png) -->\n![Actual](images/Screen%20One.png)\n");
  f.write("Example/legacy.html", "<!doctype html><h1>Report</h1>");
  f.write("Example/unreferenced.png");
  const { files } = f.generate();
  assert.deepEqual([...files.keys()].sort(), ["Example/README.md", "Example/images/Screen One.png", "Example/legacy.html", "Example/thumbnail.png", "project-catalog.json"].sort());
});

test("missing files and incorrect casing fail with the project name and image path", (t) => {
  const f = fixture(t);
  f.project();
  f.write("Example/README.md", "![Missing](images/absent.png)");
  assert.throws(f.generate, /Example:.*images\/absent\.png/);
  f.write("Example/README.md", "![Wrong case](images/screen%20One.png)");
  assert.throws(f.generate, /Example:.*incorrect filename casing/);
});

test("invalid metadata, duplicate keys, and website-owned assets fail validation", (t) => {
  const f = fixture(t);
  f.project("Example", { thumbnail: "../React_Website/public/thumbnail.png" });
  assert.throws(f.generate, /inside Example/);
  f.project("Example", { order: "first" });
  assert.throws(f.generate, /numeric order/);
  f.project("Example");
  f.project("Exam_ple");
  assert.throws(f.generate, /Duplicate.*route key/);
});

test("duplicate public assets are rejected", (t) => {
  const f = fixture(t);
  f.project();
  f.write("React_Website/public/Example/thumbnail.png");
  assert.throws(f.generate, /duplicate website asset/);
});

async function eventually(check, timeout = 8000) {
  const deadline = Date.now() + timeout;
  while (Date.now() < deadline) {
    if (await check()) return;
    await new Promise((resolve) => setTimeout(resolve, 100));
  }
  assert.fail("Development content did not regenerate in time");
}

test("development serves generated assets and watches edits, new images, and new projects", async (t) => {
  const f = fixture(t);
  f.project();
  // Match the real layout: project directories are outside Vite's website root.
  f.write("React_Website/index.html", "<!doctype html><title>Fixture</title>");
  const server = await createServer({
    configFile: false, root: path.join(f.repoRoot, "React_Website"), base: "/site/", logLevel: "silent",
    plugins: [projectContentPlugin({ repoRoot: f.repoRoot })],
    server: { host: "127.0.0.1", port: 0 },
  });
  try {
    await server.listen();
    const origin = `http://127.0.0.1:${server.httpServer.address().port}/site/`;
    const catalog = () => fetch(`${origin}project-catalog.json`);
    assert.equal((await (await catalog()).json()).projects.length, 1);
    assert.match(await (await fetch(`${origin}Example/README.md`)).text(), /Screenshot/);
    assert.equal((await fetch(`${origin}Example/images/Screen%20One.png`)).headers.get("content-type"), "image/png");
    f.write("Example/README.md", "# Updated\n![New](images/new.png)");
    await eventually(async () => (await catalog()).status === 500);
    f.write("Example/images/new.png");
    await eventually(async () => (await catalog()).status === 200);
    assert.equal((await fetch(`${origin}Example/images/new.png`)).status, 200);
    f.project("New_Project");
    await eventually(async () => {
      const response = await catalog();
      return response.ok && (await response.json()).projects.length === 2;
    });
  } finally {
    await server.close();
  }
});
