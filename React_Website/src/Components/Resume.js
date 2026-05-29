import React, { Component } from "react";
import Slide from "react-reveal";
import { Tooltip } from "react-tooltip";

class Resume extends Component {
  constructor(props) {
    super(props);
    this.rowCount = 3;
  }

  // updateWidths = () => {
  //   if (this.containerRef.current) {
  //     // const contentWidths = this.contentRefs.map(ref => ref.current?.offsetWidth || 0);
  //     this.setState({
  //       contentWidths,
  //       containerHeight: this.state.rowCount * 120,
  //     });
  //   }
  // };

  render() {
    if (!this.props.data) return null;

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

    const skillsMatrix = Array.from({ length: this.rowCount }, (_, i) =>
      this.props.data.skills.filter((_, index) => index % this.rowCount === i)
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
              <div className="skills-marquee-container">
                {skillsMatrix.map((row, rowIndex) => (
                  <div
                    key={rowIndex}
                    className={`marquee-row ${rowIndex % 2 === 1 ? "marquee-row-reverse" : ""}`}
                    style={{ "--duration": `${34 + rowIndex * 6}s` }}
                  >
                    {[0, 1].map((setIndex) => (
                      <ul key={setIndex} className="marquee-content" aria-hidden={setIndex === 1}>
                        {row.map((skill) => (
                          <li
                            key={`${setIndex}-${skill.name}`}
                            className="skill-tile"
                            data-tooltip-id="my-tooltip"
                            data-tooltip-content={skill.description}
                          >
                            <img
                              src={skill.link}
                              alt={skill.name}
                              className="skill-image"
                              loading="lazy"
                              onError={(event) => {
                                event.currentTarget.closest(".skill-tile")?.classList.add("skill-tile-fallback");
                              }}
                            />
                            <span className="skill-label">{skill.name}</span>
                          </li>
                        ))}
                      </ul>
                    ))}
                  </div>
                ))}
              </div>
              <Tooltip id="my-tooltip" className="skill-tooltip" />

            </div>
          </div>
        </Slide>

      </section >
    );
  }
}



export default Resume;
