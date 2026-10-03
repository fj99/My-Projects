import React, { useEffect, useState } from "react";
import ReactMarkdown from "react-markdown";
import remarkGfm from "remark-gfm";
import { githubFileUrl, readmeRehypePlugins, rehypeProjectUrls } from "../projectContent";

function ReadmeImage({ node, src, alt, ...props }) {
  const [failed, setFailed] = useState(false);
  useEffect(() => setFailed(false), [src]);
  if (failed || !src) {
    return <span className="project-readme-image-fallback" role="img" aria-label={alt || "Image unavailable"}>
      Image unavailable{alt ? `: ${alt}` : ""}
    </span>;
  }
  return <img {...props} src={src} alt={alt || ""} className="project-readme-image" loading="lazy" onError={() => setFailed(true)} />;
}

export default function ProjectReadme({ project, repository, onBack }) {
  const [requestNumber, setRequestNumber] = useState(0);
  const [state, setState] = useState({ status: "loading", markdown: "", error: "" });
  const directory = project.url.replace(/\/$/, "");
  const githubReadme = githubFileUrl(repository, `${directory}/README.md`);

  useEffect(() => {
    const controller = new AbortController();
    setState({ status: "loading", markdown: "", error: "" });
    async function loadReadme() {
      try {
        const response = await fetch(`${import.meta.env.BASE_URL}${project.readme}`, {
          headers: { Accept: "text/plain" }, signal: controller.signal,
        });
        if (!response.ok) throw new Error(`The site returned ${response.status}`);
        const markdown = await response.text();
        if (!controller.signal.aborted) setState({ status: "success", markdown, error: "" });
      } catch (error) {
        if (!controller.signal.aborted) setState({ status: "error", markdown: "", error: error.message });
      }
    }
    loadReadme();
    return () => controller.abort();
  }, [project.readme, requestNumber]);

  return (
    <article className="project-readme-view">
      <div className="project-readme-toolbar">
        <div className="project-readme-actions">
          <button type="button" className="button" onClick={onBack}>Back to Projects</button>
          <a className="button project-readme-github-link" href={githubReadme} target="_blank" rel="noreferrer">View on GitHub</a>
        </div>
        <span>{project.category} - {project.date}</span>
      </div>
      {state.status === "loading" && <div className="project-readme-status" role="status">Loading README…</div>}
      {state.status === "error" && (
        <div className="project-readme-status project-readme-error" role="alert">
          <h2>Unable to load this README</h2>
          <p>{state.error}. You can retry or view the canonical file on GitHub.</p>
          <button type="button" className="button" onClick={() => setRequestNumber((value) => value + 1)}>Retry</button>
        </div>
      )}
      {state.status === "success" && (
        <div className="project-readme-content">
          <ReactMarkdown
            remarkPlugins={[remarkGfm]}
            rehypePlugins={[...readmeRehypePlugins, [rehypeProjectUrls, {
              directory, repository, baseUrl: import.meta.env.BASE_URL, publicFiles: project.publicFiles,
            }]]}
            linkTarget="_blank"
            components={{
              img: ReadmeImage,
              a: ({ node, ...props }) => <a {...props} rel="noreferrer" />,
            }}
          >
            {state.markdown}
          </ReactMarkdown>
        </div>
      )}
    </article>
  );
}
