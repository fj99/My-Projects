export default function scrollToProjectContent() {
  // The document's scroll-padding keeps the content below the fixed navigation.
  const target = document.querySelector("#portfolio .portfolio-grid, #portfolio .project-readme-view")
    || document.getElementById("portfolio");
  target?.scrollIntoView({ block: "start" });
}
