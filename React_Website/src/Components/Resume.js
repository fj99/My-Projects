import React, { Component, useState, useEffect } from "react";
import Slide from "react-reveal";

class Resume extends Component {
  getRandomColor() {
    let letters = "0123456789ABCDEF";
    let color = "#";
    for (let i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  constructor(props) {
    super(props);
    this.state = { position: 0, contentWidth: 0, containerWidth: 0 };
    this.contentRef = React.createRef(); // For measuring content width
    this.containerRef = React.createRef(); // For measuring visible container width
  }

  componentDidMount() {
    this.updateWidths();

    this.interval = setInterval(() => {
      this.setState((prevState) => ({
        position:
          prevState.position < this.state.containerWidth
            ? prevState.position + 5 // Increase speed here if needed
            : -this.state.contentWidth // Reset faster
      }));
    }, 30); // Adjust speed

    window.addEventListener("resize", this.updateWidths);
  }

  componentWillUnmount() {
    clearInterval(this.interval);
    window.removeEventListener("resize", this.updateWidths);
  }

  updateWidths = () => {
    if (this.contentRef.current && this.containerRef.current) {
      this.setState({
        contentWidth: this.contentRef.current.offsetWidth, // Get width of moving content
        containerWidth: this.containerRef.current.offsetWidth, // Get width of visible container
      });
    }
  };

  render() {
    if (!this.props.data) return null;

    const skillmessage = this.props.data.skillmessage;
    const work_title = this.props.data.work_title;
    const skills_title = this.props.data.skills_title;

    const work = this.props.data.work.map(function (work) {
      return (
        <div key={work.company}>
          <h3 className="white">{work.company}</h3>
          <p className="info off-white">
            {work.title}
            <span>&bull;</span> <em className="date">{work.years}</em>
          </p>
          <p className="off-white">{work.description}</p>
        </div>
      );
    });

    const skills = this.props.data.skills.map((skills) => {
      const backgroundColor = this.getRandomColor();
      const className = "bar-expand " + skills.name.toLowerCase();
      const width = skills.level;
      return (
        <img
          src={skills.link}
          alt={skills.name}
          style={{ height: "50px" }}
        />
        // <li key={skills.name}>
        //   <span style={{ width, backgroundColor }} className={className}></span>
        //   <em className="white">{skills.name}</em>
        // </li>
      );
    });

    return (
      <section id="resume">
        <Slide left duration={1300}>
          <div className="row work">
            <div className="three columns header-col">
              <h1 className="white">
                <span>{work_title}</span>
              </h1>
            </div>

            <div className="nine columns main-col">{work}</div>
          </div>
        </Slide>

        <Slide left duration={1300}>
          <div className="row skill">
            <div className="three columns header-col">
              <h1 className="white">
                <span>{skills_title}</span>
              </h1>
            </div>

            <div className="nine columns main-col">
              <p>{this.props.skillmessage}</p>

              <div className="bars">
                <ul className="skills">
                  <div
                    ref={this.containerRef} // Measure container
                    style={{
                      position: "relative",
                      width: "100%",
                      height: "100px",
                      overflow: "hidden",
                      // border: "1px solid red", // Debugging, remove later
                    }}
                  >
                    <div
                      ref={this.contentRef} // Measure moving content
                      style={{
                        position: "absolute",
                        left: `${this.state.position}px`,
                        whiteSpace: "nowrap",
                        display: "flex",
                        alignItems: "center",
                        gap: "20px",
                      }}
                    >
                      {skills}
                    </div>
                  </div>
                </ul>
              </div>
            </div>

          </div>
        </Slide>
      </section>
    );
  }
}



export default Resume;
