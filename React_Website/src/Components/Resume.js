import React, { Component, useState, useEffect } from "react";
import Slide from "react-reveal";

class Resume extends Component {
  constructor(props) {
    super(props);
    this.state = {
      positions: Array(3).fill(0), // One position per row
      contentWidth: 0,
      containerWidth: 0,
    };
    this.contentRefs = Array(3).fill(null).map(() => React.createRef());
    this.containerRef = React.createRef();
  }

  componentDidMount() {
    this.updateWidths();

    this.intervals = this.state.positions.map((_, rowIndex) =>
      setInterval(() => {
        this.setState((prevState) => {
          const newPositions = [...prevState.positions];
          newPositions[rowIndex] =
            newPositions[rowIndex] < this.state.containerWidth
              ? newPositions[rowIndex] + (rowIndex % 2 === 0 ? 5 : 3) // Alternate speeds for a cool effect
              : -this.state.contentWidth; // Reset off-screen
          return { positions: newPositions };
        });
      }, 30)
    );

    window.addEventListener("resize", this.updateWidths);
  }

  componentWillUnmount() {
    this.intervals.forEach(clearInterval);
    window.removeEventListener("resize", this.updateWidths);
  }

  updateWidths = () => {
    if (this.containerRef.current) {
      const contentWidths = this.contentRefs.map(ref => ref.current?.offsetWidth || 0);
      this.setState({
        contentWidth: Math.max(...contentWidths), // Get max width to reset correctly
        containerWidth: this.containerRef.current.offsetWidth,
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

    const skillsMatrix = [];
    const rowCount = 3; // Adjust the number of rows as needed

    if (this.props.data && this.props.data.skills) {
      // Split skills into multiple rows dynamically
      for (let i = 0; i < rowCount; i++) {
        skillsMatrix.push(
          this.props.data.skills.filter((_, index) => index % rowCount === i)
        );
      }
    }

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
                      height: "200px",
                      overflow: "hidden",
                      display: "flex",
                      flexDirection: "column",
                      gap: "10px",
                      border: "1px solid red", // Debugging
                    }}
                  >
                    {skillsMatrix.map((row, rowIndex) => (
                      <div
                        key={rowIndex}
                        ref={this.contentRefs[rowIndex]}
                        style={{
                          position: "absolute",
                          left: `${this.state.positions[rowIndex]}px`,
                          whiteSpace: "nowrap",
                          display: "flex",
                          alignItems: "center",
                          gap: "20px",
                          top: `${rowIndex * 60}px`, // Space out rows
                        }}
                      >
                        {row.map((skill, imgIndex) => (
                          <img key={imgIndex} src={skill.link} alt={skill.name} style={{ height: "50px" }} />
                        ))}
                      </div>
                    ))}
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
