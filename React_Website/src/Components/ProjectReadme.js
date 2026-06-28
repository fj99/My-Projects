import React from "react";

function slugify(text) {
  return String(text || "")
    .replace(/README\.md$/i, "")
    .replace(/[\\/]+$/g, "")
    .replace(/[^a-z0-9]/gi, "")
    .toLowerCase();
}

function isExternalUrl(url) {
  return /^(https?:|mailto:|tel:|#)/i.test(url || "");
}

function resolveAssetUrl(url, assetBase) {
  if (!url || isExternalUrl(url)) {
    return url;
  }

  return `${assetBase}${url.replace(/^\.?\//, "")}`;
}

function renderInline(text, assetBase) {
  const parts = [];
  const pattern = /(\*\*([^*]+)\*\*)|\[([^\]]+)\]\(([^)]+)\)/g;
  let lastIndex = 0;
  let match;

  while ((match = pattern.exec(text)) !== null) {
    if (match.index > lastIndex) {
      parts.push(text.slice(lastIndex, match.index));
    }

    if (match[2]) {
      parts.push(<strong key={`strong-${match.index}`}>{match[2]}</strong>);
    } else {
      const href = resolveAssetUrl(match[4], assetBase);
      parts.push(
        <a key={`link-${match.index}`} href={href} target="_blank" rel="noreferrer">
          {match[3]}
        </a>
      );
    }

    lastIndex = pattern.lastIndex;
  }

  if (lastIndex < text.length) {
    parts.push(text.slice(lastIndex));
  }

  return parts;
}

function renderMarkdown(markdown, assetBase) {
  const lines = String(markdown || "").replace(/\r\n/g, "\n").split("\n");
  const blocks = [];
  let listItems = [];
  let codeLines = [];
  let inCodeBlock = false;

  const flushList = () => {
    if (!listItems.length) {
      return;
    }

    blocks.push(
      <ul key={`list-${blocks.length}`}>
        {listItems.map((item, index) => (
          <li key={`${item}-${index}`}>{renderInline(item, assetBase)}</li>
        ))}
      </ul>
    );
    listItems = [];
  };

  const flushCode = () => {
    if (!codeLines.length) {
      return;
    }

    blocks.push(
      <pre key={`code-${blocks.length}`}>
        <code>{codeLines.join("\n")}</code>
      </pre>
    );
    codeLines = [];
  };

  for (const line of lines) {
    if (line.trim().startsWith("```")) {
      if (inCodeBlock) {
        inCodeBlock = false;
        flushCode();
      } else {
        flushList();
        inCodeBlock = true;
      }
      continue;
    }

    if (inCodeBlock) {
      codeLines.push(line);
      continue;
    }

    const imageMatch = line.match(/^!\[([^\]]*)\]\(([^)]+)\)$/);
    if (imageMatch) {
      flushList();
      blocks.push(
        <img
          key={`image-${blocks.length}`}
          src={resolveAssetUrl(imageMatch[2], assetBase)}
          alt={imageMatch[1]}
          className="project-readme-image"
        />
      );
      continue;
    }

    const headingMatch = line.match(/^(#{1,3})\s+(.+)$/);
    if (headingMatch) {
      flushList();
      const Heading = `h${headingMatch[1].length + 1}`;
      blocks.push(
        <Heading key={`heading-${blocks.length}`}>
          {renderInline(headingMatch[2], assetBase)}
        </Heading>
      );
      continue;
    }

    const listMatch = line.match(/^\s*[-*]\s+(.+)$/);
    if (listMatch) {
      listItems.push(listMatch[1]);
      continue;
    }

    if (!line.trim()) {
      flushList();
      continue;
    }

    flushList();
    blocks.push(<p key={`paragraph-${blocks.length}`}>{renderInline(line, assetBase)}</p>);
  }

  flushList();
  flushCode();

  return blocks;
}

export function getProjectReadmeKey(project) {
  return slugify(project?.url || project?.title);
}

export default function ProjectReadme({ project, readme, onBack }) {
  const assetBase = `${import.meta.env.BASE_URL}projects/${readme.folder}/`;

  return (
    <article className="project-readme-view">
      <div className="project-readme-toolbar">
        <button type="button" className="button" onClick={onBack}>
          Back to Projects
        </button>
        <span>{project.category} - {project.date}</span>
      </div>
      <div className="project-readme-content">
        {renderMarkdown(readme.markdown, assetBase)}
      </div>
    </article>
  );
}
