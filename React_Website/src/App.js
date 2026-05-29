import React, { Component } from "react";
import ReactGA from "react-ga";
import "./App.css";
import Header from "./Components/Header";
import Footer from "./Components/Footer";
import About from "./Components/About";
import Education from "./Components/Education";
import Resume from "./Components/Resume";
import Contact from "./Components/Contact";
import Portfolio from "./Components/Portfolio";
import Background from "./Components/Backgrounds/Bounce";

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      foo: "bar",
      resumeData: {}
    };

    ReactGA.initialize("UA-110570651-1");
    ReactGA.pageview(window.location.pathname);
  }

  getResumeData() {
    fetch(`${process.env.PUBLIC_URL}/resumeData.json`, { cache: "no-store" })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Unable to load resume data: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => this.setState({ resumeData: data }))
      .catch((err) => {
        console.error(err);
        alert(err.message);
      });
  }

  componentDidMount() {
    this.getResumeData();
  }

  render() {
    return (
      <div className="App">
        <Background data={this.state.resumeData.main} />
        <Header data={this.state.resumeData.main} />
        <About data={this.state.resumeData.main} />
        <Education data={this.state.resumeData.resume} />
        <Resume data={this.state.resumeData.resume} />
        <Portfolio data={this.state.resumeData.portfolio} />
        <Contact data={this.state.resumeData.main} />
        <Footer data={this.state.resumeData.main} />
      </div>
    );
  }
}

export default App;
