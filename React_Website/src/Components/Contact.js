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
    const street = this.props.data.address.street;
    const city = this.props.data.address.city;
    const state = this.props.data.address.state;
    const zip = this.props.data.address.zip;
    const phone = this.props.data.phone;
    const email = this.props.data.email;
    const message = this.props.data.contactmessage;
    const header = this.props.data.contact_side_heading;

    const msg = this.props.data.contact_side_msg.map(function (contact_side_msg) {
      return (
        <ul id="twitter">
          <li>
            <span>
              {contact_side_msg.message}
              <br></br>
              <a href="">{contact_side_msg.url}</a>
            </span>
            <b>
              <a href="./">{contact_side_msg.date}</a>
            </b>
          </li>
        </ul>
      );
    });

    return (
      <section id="contact">
        <Fade bottom duration={1000}>
          <div className="row section-head">
            <div className="two columns header-col">
              <h1>
                <span>Get In Touch.</span>
              </h1>
            </div>

            <div className="ten columns">
              <p className="lead">{message}</p>
            </div>
          </div>
        </Fade>

        <div className="row">
          <Slide left duration={1000}>
            <div className="eight columns">
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
                      // name="contactName"
                      name="name"
                      onChange={this.handleChange}
                    />
                  </div>

                  <div>
                    <label htmlFor="contactEmail">
                      Email <span className="required">*</span>
                    </label>
                    <input
                      type="text"
                      defaultValue=""
                      size="35"
                      id="contactEmail"
                      name="email"
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
                      id="message"
                      name="contactMessage"
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
            <aside className="four columns footer-widgets">
              <div className="widget widget_contact">
                <h4>Phone and Email</h4>
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

              <div className="widget widget_tweets">
                <h4 className="widget-title">{header}</h4>
                <ul id="twitter">
                  {msg}
                </ul>
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
