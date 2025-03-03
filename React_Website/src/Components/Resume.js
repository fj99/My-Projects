import React, { Component, useState, useEffect } from "react";
import Slide from "react-reveal";
import { Tooltip } from "react-tooltip";

class Resume extends Component {
  constructor(props) {
    super(props);
    const rowCount = 6;

    this.state = {
      positions: Array(rowCount).fill(0),
      contentWidths: Array(rowCount).fill(0),
      containerHeight: rowCount * 120,
      rowCount,
    };

    this.contentRefs = Array(rowCount).fill(null).map(() => React.createRef());
    this.containerRef = React.createRef();
  }

  _componentDidMount() {
    this.updateWidths();

    this.intervals = this.state.positions.map((_, rowIndex) =>
      setInterval(() => {
        this.setState((prevState) => {
          const newPositions = [...prevState.positions];
          newPositions[rowIndex] =
            newPositions[rowIndex] < this.containerRef.current.offsetWidth
              ? newPositions[rowIndex] + (rowIndex % 2 === 0 ? 4 : 2)
              : -prevState.contentWidths[rowIndex];

          return { positions: newPositions };
        });
      }, 30)
    );
    window.addEventListener("resize", this.updateWidths);
  }

  componentDidMount() {
    this.updateWidths();
    this.intervals = this.state.positions.map((_, rowIndex) => {
      let speed;
      if (rowIndex === 0) speed = 1; // for first row
      else if (rowIndex === 1) speed = 2; // for second row
      else if (rowIndex % 2 === 0) speed = 1.5; // for even rows
      else speed = 2; // for odd rows

      return setInterval(() => {
        this.setState((prevState) => {
          const newPositions = [...prevState.positions];
          newPositions[rowIndex] =
            newPositions[rowIndex] < this.containerRef.current.offsetWidth
              ? newPositions[rowIndex] + speed
              : -prevState.contentWidths[rowIndex];

          return { positions: newPositions };
        });
      }, 30);
    });

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
        containerHeight: this.state.rowCount * 120,
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
                    ref={this.containerRef}
                    style={{
                      position: "relative",
                      width: "100%",
                      height: `${this.state.containerHeight}px`,
                      overflow: "hidden",
                      display: "flex",
                      flexDirection: "column",
                      justifyContent: "center",
                      gap: "15px",
                      // border: "1px solid red", // Debugging
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
                          top: `${(this.state.containerHeight / this.state.rowCount) * rowIndex}px`,
                          // border: "1px solid red", // Debugging
                        }}
                      >
                        {row.map((skill, imgIndex) => (
                          <img
                            key={imgIndex}
                            src={skill.link}
                            alt={skill.name}
                            style={{
                              height: "100px",
                              // border: "1px solid red", // Debugging
                            }}
                            // data-tooltip-id={imgIndex}
                            data-tooltip-id="my-tooltip"
                            data-tooltip-content={skill.description}
                          />
                        ))}

                      </div>
                    ))}
                    <Tooltip id="my-tooltip" />
                  </div>
                </ul>
              </div>


            </div>


          </div>
        </Slide>
      </section >
    );
  }
}



export default Resume;
