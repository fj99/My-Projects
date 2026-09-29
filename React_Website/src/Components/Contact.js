import React, { Component } from "react";
import { Fade, Slide } from "react-reveal";
import { Helmet } from 'react-helmet';

class Contact extends Component {
  onSubmit = (e) => {
    e.preventDefault();
    // Perform form submission logic here
    e.target.submit();
    // e.push('https://api.web3forms.com/submit');
  };

  render() {
    if (!this.props.data) return null;

    const name = this.props.data.name;
    const phone = this.props.data.phone;
    const email = this.props.data.email;
    const message = this.props.data.contactmessage;

    return (
      <section id="contact">
        <Fade bottom duration={1000}>
          <div className="row section-head">
            <p className="section-eyebrow">Contact</p>
            <h2>Let&apos;s build something useful.</h2>
            <p className="lead">{message}</p>
          </div>
        </Fade>

        <div className="row contact-layout">
          <Slide left duration={1000}>
            <div className="contact-form-card">
              <form action="https://api.web3forms.com/submit" method="POST" id="contactForm" name="contactForm" onSubmit={this.onSubmit}>
                <fieldset>
                  <div>
                    <label htmlFor="contactName">
                      Name <span className="required">*</span>
                    </label>
                    <input type="hidden" name="access_key" value="2bfdd531-494d-44bf-9539-f8f008422ee2" />
                    <input type="hidden" name="redirect" value="https://web3forms.com/success" />
                    <input type="hidden" name="from_name" value="My-Website" />
                    <input
                      type="text"
                      defaultValue=""
                      size="35"
                      id="contactName"
                      name="name"
                      autoComplete="name"
                      required
                      onChange={this.handleChange}
                    />
                  </div>

                  <div>
                    <label htmlFor="contactEmail">
                      Email <span className="required">*</span>
                    </label>
                    <input
                      type="email"
                      defaultValue=""
                      size="35"
                      id="contactEmail"
                      name="email"
                      autoComplete="email"
                      required
                      onChange={this.handleChange}
                    />
                  </div>

                  <div>
                    <label htmlFor="contactSubject">Subject</label>
                    <input
                      type="text"
                      defaultValue=""
                      size="35"
                      id="contactSubject"
                      name="subject"
                      onChange={this.handleChange}
                    />
                  </div>

                  <div>
                    <label htmlFor="contactMessage">
                      Message <span className="required">*</span>
                    </label>
                    <textarea
                      cols="50"
                      rows="15"
                      id="contactMessage"
                      name="contactMessage"
                      required
                    ></textarea>
                  </div>

                  <div>
                    <button className="submit" type="submit">Submit</button>
                    <span id="image-loader">
                      <img alt="" src="images/loader.gif" />
                    </span>
                  </div>
                </fieldset>
              </form>

              <div id="message-warning"> Error boy</div>
              <div id="message-success">
                <i className="fa fa-check"></i>Your message was sent, thank you!
                <br />
              </div>
            </div>
          </Slide>

          <Slide right duration={1000}>
            <aside className="contact-info-card footer-widgets">
              <div className="widget widget_contact">
                <p className="section-eyebrow">Direct contact</p>
                <h3>Phone and Email</h3>
                <p className="address">
                  {name}
                  <br />
                  <span>{phone}</span>
                  <br />
                  <span>
                    <a href={`mailto:${email}`}>{email}</a>
                  </span>
                </p>
              </div>

            </aside>
          </Slide>
        </div >
        <Helmet>
          <script src="https://web3forms.com/client/script.js" async defer></script>
        </Helmet>
      </section >
    );

  }
}
export default Contact;
