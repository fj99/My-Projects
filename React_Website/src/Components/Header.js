import React, { useRef, useEffect, useState } from "react";
import Fade from "react-reveal";
import Typed from 'typed.js';
import HeroScene from "./HeroScene";

const Header = (props) => {
  const type = useRef(null);
  const [isNavOpen, setIsNavOpen] = useState(false);

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
          <li className="current">
            <a className="smoothscroll" href="#home" onClick={() => setIsNavOpen(false)}>
              home
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#about" onClick={() => setIsNavOpen(false)}>
              About
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#edu" onClick={() => setIsNavOpen(false)}>
              Education
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#resume" onClick={() => setIsNavOpen(false)}>
              Experience
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#portfolio" onClick={() => setIsNavOpen(false)}>
              Projects
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#contact" onClick={() => setIsNavOpen(false)}>
              Contact
            </a>
          </li>
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
              <a href={project} className="button btn project-btn">
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
