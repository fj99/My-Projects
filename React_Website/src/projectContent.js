import { unified } from "unified";
import remarkParse from "remark-parse";
import remarkGfm from "remark-gfm";
import remarkRehype from "remark-rehype";
import rehypeRaw from "rehype-raw";
import rehypeSanitize from "rehype-sanitize";
import { visit } from "unist-util-visit";

export const readmeRehypePlugins = [rehypeRaw, rehypeSanitize];

export function getProjectReadmeKey(project) {
  return String(project.url || project.title || "")
    .replace(/[^a-z0-9]/gi, "").toLowerCase();
}

export function isExternalProjectUrl(url) {
  return /^(?:[a-z][a-z0-9+.-]*:|\/\/)/i.test(String(url || ""));
}

export function encodeRepositoryPath(value) {
  return value.split("/").map(encodeURIComponent).join("/");
}

// Decode once, normalize dot segments, and retain queries/fragments separately.
// A leading slash refers to the repository root, not the deployed site's host.
export function resolveRepositoryPath(value, directory) {
  if (!value || value.startsWith("#") || isExternalProjectUrl(value)) return null;
  const suffixIndex = value.search(/[?#]/);
  const pathname = suffixIndex < 0 ? value : value.slice(0, suffixIndex);
  const suffix = suffixIndex < 0 ? "" : value.slice(suffixIndex);
  const decoded = decodeURIComponent(pathname);
  if (/[\\\0]/.test(decoded)) throw new Error(`Invalid repository path: ${value}`);
  const parts = decoded.startsWith("/") ? [] : directory.split("/").filter(Boolean);
  for (const part of decoded.split("/")) {
    if (!part || part === ".") continue;
    if (part === "..") {
      if (!parts.length) throw new Error(`Path escapes the repository: ${value}`);
      parts.pop();
    } else {
      parts.push(part);
    }
  }
  return { path: parts.join("/"), suffix };
}

export function githubFileUrl(repository, filePath) {
  return `https://github.com/${encodeURIComponent(repository.owner)}/${encodeURIComponent(repository.name)}/blob/${encodeURIComponent(repository.branch)}/${encodeRepositoryPath(filePath)}`;
}

export function resolveReadmeImage(src, directory, baseUrl) {
  if (!src) return "";
  if (isExternalProjectUrl(src)) {
    let url;
    try { url = new URL(src.startsWith("//") ? `https:${src}` : src); }
    catch { return ""; }
    if (!["https:", "http:"].includes(url.protocol)) return "";
    const segments = url.pathname.split("/");
    if (url.hostname === "github.com" && segments[3] === "blob") {
      url.hostname = "raw.githubusercontent.com";
      segments.splice(3, 1);
      url.pathname = segments.join("/");
      url.searchParams.delete("raw");
    }
    return url.href;
  }
  const local = resolveRepositoryPath(src, directory);
  return local ? `${baseUrl}${encodeRepositoryPath(local.path)}${local.suffix}` : "";
}

export function resolveReadmeLink(href, directory, repository, baseUrl, publicFiles = []) {
  if (!href || href.startsWith("#") || isExternalProjectUrl(href)) return href;
  const local = resolveRepositoryPath(href, directory);
  const published = publicFiles.some((file) => resolveRepositoryPath(file, directory)?.path === local.path);
  return `${published ? baseUrl + encodeRepositoryPath(local.path) : githubFileUrl(repository, local.path)}${local.suffix}`;
}

export function parseReadme(markdown) {
  const processor = unified().use(remarkParse).use(remarkGfm)
    .use(remarkRehype, { allowDangerousHtml: true })
    .use(rehypeRaw).use(rehypeSanitize);
  return processor.runSync(processor.parse(markdown));
}

export function readmeImageSources(markdown) {
  const sources = [];
  visit(parseReadme(markdown), "element", (node) => {
    if (node.tagName === "img" && node.properties?.src) sources.push(String(node.properties.src));
  });
  return sources;
}

// Run after sanitization so both Markdown images and HTML <img> use the same rules.
export function rehypeProjectUrls({ directory, repository, baseUrl, publicFiles }) {
  return (tree) => visit(tree, "element", (node) => {
    if (node.tagName === "img" && node.properties.src) {
      node.properties.src = resolveReadmeImage(String(node.properties.src), directory, baseUrl);
    }
    if (node.tagName === "a" && node.properties.href) {
      node.properties.href = resolveReadmeLink(String(node.properties.href), directory, repository, baseUrl, publicFiles);
    }
  });
}
