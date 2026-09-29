import { useEffect } from "react";

const SELECTOR = [
  ".about-copy",
  ".about-contact-card",
  ".education-card",
  ".experience-card",
  ".portfolio-card",
  ".contact-form-card",
  ".contact-info-card",
].join(",");

export default function InteractiveDepth() {
  useEffect(() => {
    const finePointer = window.matchMedia("(hover: hover) and (pointer: fine)");
    const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
    if (!finePointer.matches || reducedMotion.matches) return undefined;

    const cleanups = new Map();

    const connect = (element) => {
      if (cleanups.has(element)) return;

      const move = (event) => {
        const bounds = element.getBoundingClientRect();
        const x = (event.clientX - bounds.left) / bounds.width;
        const y = (event.clientY - bounds.top) / bounds.height;
        element.style.setProperty("--glow-x", `${x * 100}%`);
        element.style.setProperty("--glow-y", `${y * 100}%`);
        element.style.setProperty("--tilt-x", `${(0.5 - y) * 7}deg`);
        element.style.setProperty("--tilt-y", `${(x - 0.5) * 8}deg`);
      };

      const enter = () => element.classList.add("is-depth-active");
      const leave = () => {
        element.classList.remove("is-depth-active");
        element.style.setProperty("--tilt-x", "0deg");
        element.style.setProperty("--tilt-y", "0deg");
      };

      element.addEventListener("pointermove", move);
      element.addEventListener("pointerenter", enter);
      element.addEventListener("pointerleave", leave);
      cleanups.set(element, () => {
        element.removeEventListener("pointermove", move);
        element.removeEventListener("pointerenter", enter);
        element.removeEventListener("pointerleave", leave);
      });
    };

    const scan = () => document.querySelectorAll(SELECTOR).forEach(connect);
    scan();

    const observer = new MutationObserver(scan);
    observer.observe(document.body, { childList: true, subtree: true });

    return () => {
      observer.disconnect();
      cleanups.forEach((cleanup) => cleanup());
      cleanups.clear();
    };
  }, []);

  return null;
}
