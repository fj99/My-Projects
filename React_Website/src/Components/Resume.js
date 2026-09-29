import React, { Component } from "react";
import Slide from "react-reveal";
import { Tooltip } from "react-tooltip";

class Resume extends Component {
  constructor(props) {
    super(props);
    this.rowCount = 3;
  }

  render() {
    if (!this.props.data) return null;

    const work_title = this.props.data.work_title;
    const skills_title = this.props.data.skills_title;

    const work = this.props.data.work.map(function (work, index) {
      return (
        <Slide
          left
          duration={1100}
          delay={index * 140}
          key={`${work.company}-${work.title}-${work.years}`}
        >
          <article className="experience-card">
            <h3 className="white">{work.company}</h3>
            <p className="info off-white">
              {work.title}
              <span>&bull;</span> <em className="date">{work.years}</em>
            </p>
            <p className="off-white">{work.description}</p>
          </article>
        </Slide>
      );
    });

    const skillsMatrix = Array.from({ length: this.rowCount }, (_, i) =>
      this.props.data.skills.filter((_, index) => index % this.rowCount === i)
    );

    return (
      <section id="resume">
        <div className="row work">
          <Slide left duration={1300}>
            <div className="section-heading section-heading-left">
              <p className="section-eyebrow">Career</p>
              <h2>{work_title}</h2>
            </div>
          </Slide>
          <div className="experience-list">{work}</div>
        </div>

        <Slide left duration={1300}>
          <div className="row skill">
            <div className="section-heading section-heading-left">
              <p className="section-eyebrow">Toolbox</p>
              <h2>{skills_title}</h2>
              <p className="skills-intro">
                A practical mix of application development, cloud, data, and AI technologies.
              </p>
            </div>
            <div className="skills-panel">
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
