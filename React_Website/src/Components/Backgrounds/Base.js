import React, { Component } from "react";
import { tsParticles } from "tsparticles";

class Background extends Component {
  constructor(props) {
    super(props);
    this.containerRef = React.createRef();
  }

  containerRef = React.createRef();

  componentDidMount() {
    if (this.containerRef.current) {

      // Enter Design here

    }
  }
  render() {
    return (
      <>
        <div className="custm-bg" id="tsparticles" ref={this.containerRef} />
      </>
    );
  }
}
export default Background;
