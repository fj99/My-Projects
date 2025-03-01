import React, { Component, useState, useEffect } from "react";
import Slide from "react-reveal";

class Resume extends Component {
  constructor(props) {
    super(props);
    const rowCount = 4; // Adjust to test different row counts

    this.state = {
      positions: Array(rowCount).fill(0), // Position for each row
      contentWidths: Array(rowCount).fill(0), // Content width tracking
      containerHeight: rowCount * 60, // Dynamic height based on rowCount
      rowCount,
    };

    this.contentRefs = Array(rowCount).fill(null).map(() => React.createRef());
    this.containerRef = React.createRef(); // Correct ref initialization
  }

  componentDidMount() {
    this.updateWidths();

    // Create independent intervals for each row
    this.intervals = this.state.positions.map((_, rowIndex) =>
      setInterval(() => {
        this.setState((prevState) => {
          const newPositions = [...prevState.positions];
          newPositions[rowIndex] =
            newPositions[rowIndex] < this.containerRef.current.offsetWidth
              ? newPositions[rowIndex] + (rowIndex % 2 === 0 ? 4 : 2) // Alternating speeds
              : -prevState.contentWidths[rowIndex]; // Reset smoothly

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
        contentWidths,
        containerHeight: this.state.rowCount * 60, // Adjust height dynamically
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

    // **Split skills dynamically into `rowCount` rows**
    const skillsMatrix = Array.from({ length: this.state.rowCount }, (_, i) =>
      this.props.data.skills.filter((_, index) => index % this.state.rowCount === i)
    );

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
                      height: `${this.state.containerHeight}px`, // Dynamically adjusts height
                      overflow: "hidden",
                      display: "flex",
                      flexDirection: "column",
                      justifyContent: "center", // Center all rows properly
                      gap: "15px",
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
                          top: `${(this.state.containerHeight / this.state.rowCount) * rowIndex}px`, // Proper spacing
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
