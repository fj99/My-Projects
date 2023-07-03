import React, { Component } from "react";
import { tsParticles } from "tsparticles";

class Background extends Component {
  constructor(props) {
    super(props);
    this.containerRef = React.createRef();
  }

  containerRef = React.createRef();

  componentDidMount() {

    //tsParticles library - https://github.com/matteobruni/tsparticles
    //Big Circles preset - https://github.com/matteobruni/tsparticles/presets/bigCircles

    if (this.containerRef.current) {
      tsParticles.load("tsparticles", {
        backgroundMask: {
          enable: true,
          cover: {
            value: {
              r: 0,
              g: 0,
              b: 0
            }
          }
        },
        background: {
          image: "url('https://particles.js.org/images/background.jpg')",
          size: "100% 100%",
          repeat: "no-repeat"
        },
        fullScreen: {
          enable: true,
          zIndex: -1
        },
        particles: {
          color: {
            value: ["#1E00FF", "#FF0061", "#E1FF00", "#00FF9E"],
            animation: {
              enable: true,
              speed: 30
            }
          },
          move: {
            direction: "bottom",
            enable: true,
            outModes: {
              default: "out"
            },
            size: true,
            speed: {
              min: 1,
              max: 3
            }
          },
          number: {
            value: 700,
            density: {
              enable: true,
              area: 800
            }
          },
          opacity: {
            value: 1,
            animation: {
              enable: false,
              startValue: "max",
              destroy: "min",
              speed: 0.3,
              sync: true
            }
          },
          rotate: {
            value: {
              min: 0,
              max: 360
            },
            direction: "random",
            move: true,
            animation: {
              enable: true,
              speed: 60
            }
          },
          tilt: {
            direction: "random",
            enable: true,
            move: true,
            value: {
              min: 0,
              max: 360
            },
            animation: {
              enable: true,
              speed: 60
            }
          },
          shape: {
            type: ["circle", "square", "polygon"],
            options: {
              polygon: [
                {
                  sides: 5
                },
                {
                  sides: 6
                }
              ]
            }
          },
          size: {
            value: {
              min: 3,
              max: 5
            }
          },
          roll: {
            darken: {
              enable: true,
              value: 30
            },
            enlighten: {
              enable: true,
              value: 30
            },
            enable: true,
            speed: {
              min: 15,
              max: 25
            }
          },
          wobble: {
            distance: 30,
            enable: true,
            move: true,
            speed: {
              min: -15,
              max: 15
            }
          }
        }
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