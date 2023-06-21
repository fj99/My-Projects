import React, { useRef, useEffect } from "react";
import ParticlesBg from "particles-bg";
import Fade from "react-reveal";
import Typed from 'typed.js';

const Header = (props) => {
  const el = useRef(null);

  useEffect(() => {
    if (props.data) {
      const description = props.data.description;
      const typed = new Typed(el.current, {
        // strings: ['<i>First</i> sentence.', '&amp; a second sentence.'],
        strings: description,
        typeSpeed: 50,
        backSpeed: 50,
        loop: true
      });

      return () => {
        // Destroy Typed instance during cleanup to stop animation
        typed.destroy();
      };
    }
  }, [props.data]);

  if (!props.data) return null;

  const project = props.data.project;
  const github = props.data.github;
  const name = props.data.name;
  // const description = props.data.description;

  return (
    <header id="home">
      <ParticlesBg type="circle" bg={true} />

      <nav id="nav-wrap">
        <a className="mobile-btn" href="#nav-wrap" title="Show navigation">
          Show navigation
        </a>
        <a className="mobile-btn" href="#home" title="Hide navigation">
          Hide navigation
        </a>

        <ul id="nav" className="nav">
          <li className="current">
            <a className="smoothscroll" href="#home">
              Home
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#about">
              About
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#edu">
              Education
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#resume">
              Experience
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#portfolio">
              Projects
            </a>
          </li>

          <li>
            <a className="smoothscroll" href="#contact">
              Contact
            </a>
          </li>
        </ul>
      </nav>

      <div className="row banner">
        <div className="banner-text">
          <Fade bottom>
            <h1 className="responsive-headline">{name}</h1>
          </Fade>
          <Fade bottom duration={1200}>
            <div className="App">
              <h3>
                a <span ref={el} />
              </h3>
            </div>
          </Fade>
          <hr />
          <Fade bottom duration={2000}>
            <ul className="social">
              <a href={project} className="button btn project-btn">
                <i className="fa fa-book"></i>Projects
              </a>
              <a href={github} className="button btn github-btn">
                <i className="fa fa-github"></i>Github
              </a>
            </ul>
          </Fade>
        </div>
      </div>

      <p className="scrolldown">
        <a className="smoothscroll" href="#about">
          <i className="icon-down-circle"></i>
        </a>
      </p>
    </header>
  );
};

export default Header;
