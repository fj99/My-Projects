import React, { Component } from "react";
import { tsParticles } from "tsparticles";

class Background extends Component {
  constructor(props) {
    super(props);
    this.containerRef = React.createRef();
  }

  containerRef = React.createRef();

  componentDidMount() {
    // if (!this.props.data) return null;
    if (this.props.data) {
      var background = this.props.data.background_colors;
    } else {
      var background = ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"];
    }

    if (this.containerRef.current) {
      tsParticles.load("tsparticles", {
        particles: {
          number: {
            value: 80,
            density: {
              enable: true,
              area: 800,
            },
          },
          color: {
            value: background,
            // value: ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"],
          },
          shape: {
            type: "circle",
            stroke: {
              width: 0,
              color: '#b6b2b2',
            },
          },
          opacity: {
            value: 0.5211089197812949,
            random: false,
            animation: {
              enable: true,
              speed: 1,
              minimumValue: 0.1,
              sync: false,
            },
          },
          size: {
            value: 10.017060304327615,
            random: true,
            animation: {
              enable: true,
              speed: 12.181158184520175,
              minimumValue: 0.1,
              sync: false,
            },
          },
          lineLinked: {
            enable: false,
            distance: 150,
            color: "#c8c8c8",
            opacity: 0.4,
            width: 1,
          },
          move: {
            enable: true,
            speed: 1,
            direction: "none",
            random: false,
            straight: false,
            outMode: "bounce",
            bounce: false,
            attract: {
              enable: false,
              rotateX: 600,
              rotateY: 1200,
            },
          },
        },
        interactivity: {
          detectOn: "canvas",
          events: {
            onHover: {
              enable: true,
              mode: "connect",
            },
            onClick: {
              enable: true,
              mode: "push",
            },
            resize: true,
          },
          modes: {
            grab: {
              distance: 800,
              lineLinked: {
                opacity: 1,
              },
            },
            bubble: {
              distance: 400,
              size: 40,
              duration: 2,
              opacity: 8,
              speed: 3,
            },
            connect: {},
            repulse: {
              distance: 200,
              duration: 0.4,
            },
            push: {
              particles_nb: 4,
            },
            remove: {
              particles_nb: 2,
            },
          },
        },
        detectRetina: true,
      });
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
