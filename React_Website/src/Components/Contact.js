import React, { Component } from "react";
import { Fade, Slide } from "react-reveal";
import { CONTACT_ENDPOINT, submitContact } from "../contactSubmission";

class Contact extends Component {
  state = { status: "idle", error: "" };
  submitting = false;

  onSubmit = async (e) => {
    e.preventDefault();
    if (this.submitting) return;

    const form = e.currentTarget;
    if (!form.reportValidity()) return;
    const formData = new FormData(form);
    this.submitting = true;
    this.setState({ status: "sending", error: "" });

    try {
      await submitContact(formData);
      form.reset();
      this.setState({ status: "success" });
    } catch (error) {
      this.setState({ status: "error", error: error.message });
    } finally {
      this.submitting = false;
    }
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
              <form action={CONTACT_ENDPOINT} method="POST" id="contactForm" name="contactForm" onSubmit={this.onSubmit} aria-busy={this.state.status === "sending"}>
                <fieldset disabled={this.state.status === "sending"}>
                  <div>
                    <label htmlFor="contactName">
                      Name <span className="required">*</span>
                    </label>
                    <input type="hidden" name="access_key" value="2bfdd531-494d-44bf-9539-f8f008422ee2" />
                    <input type="hidden" name="from_name" value="My-Website" />
                    <div hidden>
                      <input type="checkbox" name="botcheck" tabIndex={-1} aria-label="Leave this field empty" />
                    </div>
                    <input
                      type="text"
                      defaultValue=""
                      size="35"
                      id="contactName"
                      name="name"
                      autoComplete="name"
                      required
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
                      name="message"
                      required
                    ></textarea>
                  </div>

                  <div>
                    <button className="submit" type="submit">
                      {this.state.status === "sending" ? "Sending…" : "Send message"}
                    </button>
                  </div>
                </fieldset>
              </form>

              <div className="contact-status" role="status" aria-live="polite">
                {this.state.status === "sending" && <p>Sending your message…</p>}
                {this.state.status === "success" && <p className="contact-status-success">Thank you! Your message has been submitted.</p>}
              </div>
              {this.state.status === "error" && (
                <div className="contact-status contact-status-error" role="alert">
                  <p>{this.state.error}</p>
                  <a href={`mailto:${email}`}>Email me directly at {email}</a>
                </div>
              )}
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
      </section >
    );

  }
}
export default Contact;
