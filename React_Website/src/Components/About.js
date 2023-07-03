import React, { Component } from "react";
import Fade from "react-reveal";
// import { IoIosCall } from "react-icons/io";
import { FaPhone, FaEnvelope, FaLinkedin } from "react-icons/fa";

class About extends Component {
  render() {
    if (!this.props.data) return null;

    const name = this.props.data.name;
    const profile_pic = this.props.data.profile_pic;
    const bio = this.props.data.bio;
    const street = this.props.data.address.street;
    const city = this.props.data.address.city;
    const state = this.props.data.address.state;
    const zip = this.props.data.address.zip;
    const phone = this.props.data.phone;
    const email = this.props.data.email;
    const resume = this.props.data.resume;
    const linkedin = this.props.data.linkedin;


    return (
      <section id="about">
        <Fade duration={1000}>
          <div className="row">
            <div className="three columns">
              <img
                className="profile-pic"
                src={profile_pic}
                alt="Profile Pic"
              />
            </div>
            <div className="nine columns main-col">
              <h2>About Me</h2>

              <p>{bio}</p>
              <div className="row">
                <div className="columns contact-details">
                  <h2>Contact Details</h2>
                  <p className="address">
                    <FaLinkedin /> <a href={linkedin} target="_blank">{name}</a>
                    {/* <span>{name}</span> 
                    <br />
                    <span>
                      {street}
                      <br />
                      {city} {state}, {zip}
                    </span> */}
                    <br />
                    <FaPhone /> <span>{phone}</span>
                    <br />
                    <FaEnvelope /> <a href={`mailto:${email}`} target="_blank">{email}</a>
                  </p>
                </div>
                <div className="columns download">
                  <p>
                    <a href={resume} download="Felix-Fernandez-Resume" className="button">
                      <i className="fa fa-download"></i>Download Resume
                    </a>
                  </p>
                </div>
                <div className="columns download">
                  <p>
                    <a href={resume} target="_blank" className="button">
                      <i className="fa fa-folder-open"></i>Open Resume
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </Fade>
      </section>
    );
  }
}

export default About;
