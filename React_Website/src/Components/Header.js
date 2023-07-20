import React, { useRef, useEffect, Component } from "react";
import Fade from "react-reveal";
import Typed from 'typed.js';

const Header = (props) => {
  const type = useRef(null);

  useEffect(() => {
    if (props.data) {
      const description = props.data.description;
      const typed = new Typed(type.current, {
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
  const nav = props.data.navbar;
  // const network = this.props.data.social[0];
  // const networkElement = (
  //   <>
  //     <a href={network.url} className="button btn github-btn">
  //       <i className="fa fa-github"></i>Github
  //     </a>
  //   </>
  // );

  return (
    <header id="home">

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
              home
              {/* {nav} */}
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
                a <span ref={type} />
              </h3>
            </div>
          </Fade>
          <hr />
          <Fade bottom duration={2000}>
            <ul className="social">
              <a href={project} className="button btn project-btn">
                <i className="fa fa-book"></i>Projects
              </a>
              <a href={github} target="_blank" className="button btn github-btn">
                <i className="fa fa-github"></i>Github
              </a>
              {/* {networkElement} */}
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
