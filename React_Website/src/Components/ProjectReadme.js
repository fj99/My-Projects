import React, { useEffect, useMemo, useState } from "react";
import ReactMarkdown, { uriTransformer } from "react-markdown";
import remarkGfm from "remark-gfm";

function trimProjectPath(value) {
  return String(value || "")
    .split(/[?#]/)[0]
    .replace(/^\.?\//, "")
    .replace(/\/+$/g, "");
}

function encodePath(value) {
  return trimProjectPath(value)
    .split("/")
    .filter(Boolean)
    .map(encodeURIComponent)
    .join("/");
}

function buildProjectSources(project, repository) {
  const owner = encodeURIComponent(repository?.owner || "");
  const name = encodeURIComponent(repository?.name || "");
  const branch = encodeURIComponent(repository?.branch || "main");
  const projectPath = encodePath(project?.url);
  const rawRoot = `https://raw.githubusercontent.com/${owner}/${name}/${branch}/`;
  const githubRoot = `https://github.com/${owner}/${name}`;

  const makeSource = (path) => ({
    readme: `${rawRoot}${path}/README.md`,
    rawAssets: `${rawRoot}${path}/`,
    githubAssets: `${githubRoot}/blob/${branch}/${path}/`,
    githubReadme: `${githubRoot}/blob/${branch}/${path}/README.md`,
  });

  return [
    makeSource(projectPath),
    makeSource(`React_Website/public/${projectPath}`),
  ];
}

function resolveMarkdownUrl(url, baseUrl) {
  if (!url || url.startsWith("#")) {
    return url;
  }

  try {
    return uriTransformer(new URL(url, baseUrl).href);
  } catch {
    return "";
  }
}

export function getProjectReadmeKey(project) {
  return trimProjectPath(project?.url || project?.title)
    .replace(/[^a-z0-9]/gi, "")
    .toLowerCase();
}

export function isExternalProjectUrl(url) {
  return /^(?:[a-z][a-z0-9+.-]*:|\/\/)/i.test(String(url || ""));
}

export default function ProjectReadme({ project, repository, onBack }) {
  const sources = useMemo(
    () => buildProjectSources(project, repository),
    [project, repository]
  );
  const [requestNumber, setRequestNumber] = useState(0);
  const [state, setState] = useState({
    status: "loading",
    markdown: "",
    error: "",
    source: null,
  });

  useEffect(() => {
    const controller = new AbortController();
    setState({ status: "loading", markdown: "", error: "", source: null });

    async function loadReadme() {
      try {
        let lastStatus = 404;

        for (const source of sources) {
          const response = await fetch(source.readme, {
            cache: "no-store",
            headers: { Accept: "text/plain" },
            signal: controller.signal,
          });

          if (response.ok) {
            const markdown = await response.text();
            setState({ status: "success", markdown, error: "", source });
            return;
          }

          lastStatus = response.status;
          if (response.status !== 404) {
            break;
          }
        }

        throw new Error(`GitHub returned ${lastStatus}`);
      } catch (error) {
        if (error.name !== "AbortError") {
          setState({
            status: "error",
            markdown: "",
            error: error.message || "The README could not be loaded.",
            source: null,
          });
        }
      }
    }

    loadReadme();

    return () => controller.abort();
  }, [sources, requestNumber]);

  const retry = () => setRequestNumber((value) => value + 1);

  return (
    <article className="project-readme-view">
      <div className="project-readme-toolbar">
        <div className="project-readme-actions">
          <button type="button" className="button" onClick={onBack}>
            Back to Projects
          </button>
          <a
            className="button project-readme-github-link"
            href={(state.source || sources[0]).githubReadme}
            target="_blank"
            rel="noreferrer"
          >
            View on GitHub
          </a>
        </div>
        <span>{project.category} - {project.date}</span>
      </div>

      {state.status === "loading" && (
        <div className="project-readme-status" role="status">
          Loading README from GitHub…
        </div>
      )}

      {state.status === "error" && (
        <div className="project-readme-status project-readme-error" role="alert">
          <h2>Unable to load this README</h2>
          <p>{state.error}. You can retry or view the canonical file on GitHub.</p>
          <button type="button" className="button" onClick={retry}>
            Retry
          </button>
        </div>
      )}

      {state.status === "success" && (
        <div className="project-readme-content">
          <ReactMarkdown
            remarkPlugins={[remarkGfm]}
            skipHtml
            linkTarget="_blank"
            transformLinkUri={(href) =>
              resolveMarkdownUrl(href, state.source.githubAssets)
            }
            transformImageUri={(src) =>
              resolveMarkdownUrl(src, state.source.rawAssets)
            }
            components={{
              img: ({ node, ...props }) => (
                <img {...props} className="project-readme-image" loading="lazy" />
              ),
            }}
          >
            {state.markdown}
          </ReactMarkdown>
        </div>
      )}
    </article>
  );
}
