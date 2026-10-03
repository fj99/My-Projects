import React, { useRef, useEffect, useState } from "react";
import Fade from "react-reveal";
import Typed from 'typed.js';
import HeroScene from "./HeroScene";
import scrollToProjectContent from "../scrollToProjectContent";

const navigation = [
  { id: "home", label: "Home" },
  { id: "about", label: "About" },
  { id: "edu", label: "Education" },
  { id: "resume", label: "Experience" },
  { id: "portfolio", label: "Projects" },
  { id: "contact", label: "Contact" },
];

const Header = (props) => {
  const type = useRef(null);
  const [isNavOpen, setIsNavOpen] = useState(false);
  const [activeSection, setActiveSection] = useState("home");

  useEffect(() => {
    if (!props.data) return undefined;
    const sections = navigation.map(({ id }) => document.getElementById(id)).filter(Boolean);
    let frame = null;

    const updateActiveSection = () => {
      frame = null;
      // Track the section near the top of the reading area, below the fixed nav.
      const navOffset = parseFloat(getComputedStyle(document.documentElement).scrollPaddingTop) || 84;
      const readingLine = Math.max(navOffset, window.innerHeight * 0.3);
      let current = sections[0]?.id || "home";
      for (const section of sections) {
        if (section.getBoundingClientRect().top <= readingLine) current = section.id;
      }
      if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 2) {
        current = sections[sections.length - 1]?.id || current;
      }
      setActiveSection(current);
    };

    const scheduleUpdate = () => {
      if (frame === null) frame = window.requestAnimationFrame(updateActiveSection);
    };
    const observer = new ResizeObserver(scheduleUpdate);
    sections.forEach((section) => observer.observe(section));
    window.addEventListener("scroll", scheduleUpdate, { passive: true });
    window.addEventListener("resize", scheduleUpdate);
    scheduleUpdate();

    return () => {
      window.removeEventListener("scroll", scheduleUpdate);
      window.removeEventListener("resize", scheduleUpdate);
      observer.disconnect();
      if (frame !== null) window.cancelAnimationFrame(frame);
    };
  }, [props.data]);

  useEffect(() => {
    if (props.data) {
      const description = props.data.description;
      const typed = new Typed(type.current, {
        strings: description,
        typeSpeed: 50,
        backSpeed: 50,
        loop: true
      });

      return () => {
        typed.destroy();
      };
    }
  }, [props.data]);

  useEffect(() => {
    if (!isNavOpen) return undefined;

    const closeOnEscape = (event) => {
      if (event.key === "Escape") {
        setIsNavOpen(false);
      }
    };

    window.addEventListener("keydown", closeOnEscape);
    return () => window.removeEventListener("keydown", closeOnEscape);
  }, [isNavOpen]);

  const handleNavigationClick = (event) => {
    setIsNavOpen(false);
    if (event.defaultPrevented || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
    if (event.currentTarget.getAttribute("href") === "#portfolio" && window.location.hash === "#portfolio") {
      event.preventDefault();
      scrollToProjectContent();
    }
  };

  if (!props.data) return null;

  const project = props.data.project;
  const github = props.data.github;
  const name = props.data.name;

  return (
    <>
      {/* Keep fixed navigation outside the hero's perspective container. */}
      <nav id="nav-wrap" className={isNavOpen ? "is-open" : ""}>
        <button
          className="mobile-menu-toggle"
          type="button"
          aria-label={isNavOpen ? "Close navigation" : "Open navigation"}
          aria-controls="nav"
          aria-expanded={isNavOpen}
          onClick={() => setIsNavOpen((open) => !open)}
        >
          <span aria-hidden="true"></span>
        </button>

        <ul id="nav" className="nav">
          {navigation.map(({ id, label }) => (
            <li key={id} className={activeSection === id ? "current" : undefined}>
              <a
                className="smoothscroll"
                href={`#${id}`}
                aria-current={activeSection === id ? "location" : undefined}
                onClick={handleNavigationClick}
              >
                {label}
              </a>
            </li>
          ))}
        </ul>
      </nav>

    <header id="home">
      <div className="row banner">
        <div className="hero-shell">
        <div className="banner-text hero-copy">
          <Fade bottom duration={800}>
            <p className="hero-kicker"><span className="hero-status-dot" /> Available for ambitious projects</p>
          </Fade>
          <Fade bottom>
            <h1 className="responsive-headline">{name}</h1>
          </Fade>
          <Fade bottom duration={1200}>
            <div className="hero-role">
              <h3>
                <span ref={type} />
              </h3>
            </div>
          </Fade>
          <p className="hero-summary">
            {props.data.summary}
          </p>
          <Fade bottom duration={2000}>
            <div className="hero-actions">
              <a href={project} className="button btn project-btn" onClick={handleNavigationClick}>
                <i className="fa fa-book"></i>Projects
              </a>
              <a href={github} target="_blank" rel="noreferrer" className="button btn github-btn">
                <i className="fa fa-github"></i>Github
              </a>
            </div>
          </Fade>
        </div>
        <Fade right duration={1200} distance="30px">
          <HeroScene />
        </Fade>
        </div>
      </div>

      <p className="scrolldown">
        <a className="smoothscroll" href="#about">
          <span>Scroll to explore</span>
          <i className="icon-down-circle"></i>
        </a>
      </p>
    </header>
    </>
  );
};

export default Header;
