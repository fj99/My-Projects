import React, { Component } from "react";
import Fade from "react-reveal";
import { FaPhone, FaEnvelope } from "react-icons/fa";

class About extends Component {
  render() {
    if (!this.props.data) return null;

    const name = this.props.data.name;
    const bio = this.props.data.bio;
    const years = new Date().getFullYear() - 2019;
    const renderedBio = bio.replace("{years}", years);
    const phone = this.props.data.phone;
    const email = this.props.data.email;
    const resume = this.props.data.resume;
    const network = this.props.data.social[0];
    const networkElement = (
      <>
        <a href={network.url} target="_blank" rel="noreferrer">
          {name}
        </a>
      </>
    );

    return (
      <section id="about">
        <Fade duration={1000}>
          <div className="row about-shell">
            <div className="about-copy">
              <p className="section-eyebrow">About me</p>
              <h2>Engineering with curiosity and measurable impact.</h2>
              <p className="about-bio">{renderedBio}</p>
              <div className="about-actions">
                <a href={resume} download="Felix-Fernandez-Resume" className="button button-primary">
                  <i className="fa fa-download"></i>Download Resume
                </a>
                <a href={resume} target="_blank" rel="noreferrer" className="button button-secondary">
                  <i className="fa fa-folder-open"></i>Open Resume
                </a>
              </div>
            </div>
            <aside className="about-contact-card">
              <p className="section-eyebrow">Contact details</p>
              <h3>Let&apos;s connect</h3>
              <div className="contact-detail-row">
                <span className="contact-detail-icon"><i className={network.className}></i></span>
                <span>{networkElement}</span>
              </div>
              <div className="contact-detail-row">
                <span className="contact-detail-icon"><FaPhone /></span>
                <a href={`tel:${phone.replace(/[^\d+]/g, "")}`}>{phone}</a>
              </div>
              <div className="contact-detail-row">
                <span className="contact-detail-icon"><FaEnvelope /></span>
                <a href={`mailto:${email}`}>{email}</a>
              </div>
            </aside>
          </div>
        </Fade>
      </section>
    );
  }
}

export default About;
