import React, { Component } from "react";
import Slide from "react-reveal";
import { Tooltip } from "react-tooltip";

class Resume extends Component {
  constructor(props) {
    super(props);
    const rowCount = 3;

    this.state = {
      positions: Array(rowCount).fill(0), // Initialize positions to 0
      contentWidths: Array(rowCount).fill(0), // To store the width of the images
      containerHeight: rowCount * 120,
      rowCount,
    };

    this.contentRefs = Array(rowCount).fill(null).map(() => React.createRef());
    this.containerRef = React.createRef();
  }

  componentDidMount() {
    this.updateWidths();
    this.startAnimation(); // Start animation after setting initial widths
    window.addEventListener("resize", this.updateWidths);
  }

  componentWillUnmount() {
    // Clear intervals on unmount
    this.intervals.forEach(clearInterval);
    window.removeEventListener("resize", this.updateWidths);
  }

  updateWidths = () => {
    if (this.containerRef.current) {
      const contentWidths = this.contentRefs.map((ref) => ref.current?.offsetWidth || 0);
      this.setState({
        contentWidths,
        containerHeight: this.state.rowCount * 120,
      });
    }
  };

  startAnimation = () => {
    // Set an interval to update the position of each row
    this.intervals = this.state.positions.map((_, rowIndex) => {
      let speed = rowIndex % 2 === 0 ? 2 : 3; // Different speed for rows

      return setInterval(() => {
        this.setState((prevState) => {
          const newPositions = [...prevState.positions]; // Make a copy of positions

          // Update positions for each row independently
          newPositions[rowIndex] = newPositions[rowIndex] + speed;

          // If a row's position goes beyond the container's width, reset it
          if (newPositions[rowIndex] >= this.containerRef.current.offsetWidth) {
            newPositions[rowIndex] = -prevState.contentWidths[rowIndex]; // Loop back
          }

          return { positions: newPositions };
        });
      }, 30); // Update every 30ms
    });
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
                    }}
                  >
                    {skillsMatrix.map((row, rowIndex) => (
                      <div
                        key={rowIndex}
                        ref={this.contentRefs[rowIndex]}
                        style={{
                          position: "absolute",
                          left: `${this.state.positions[rowIndex]}px`, // Move the row by its position
                          whiteSpace: "nowrap",
                          display: "flex",
                          alignItems: "center",
                          gap: "20px",
                          top: `${(this.state.containerHeight / this.state.rowCount) * rowIndex}px`,
                        }}
                      >
                        {row.map((skill, imgIndex) => (
                          <img
                            key={imgIndex}
                            src={skill.link}
                            alt={skill.name}
                            style={{
                              height: "100px",
                              width: "auto", // Let images keep their natural width
                              border: "1px solid red", // Debugging
                              display: "inline-block", // Prevents collapsing width
                            }}
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
