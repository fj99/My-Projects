import React, { useEffect, useRef } from "react";
import { tsParticles } from "tsparticles";

const App = () => {
  const containerRef = useRef(null);

  useEffect(() => {
    if (containerRef.current) {
      tsParticles.load("tsparticles", {
        background: {
          color: {
            value: "#0d47a1",
          },
        },
        fpsLimit: 120,
        interactivity: {
          events: {
            onClick: {
              enable: true,
              mode: "push",
            },
            onHover: {
              enable: true,
              mode: "repulse",
            },
            resize: true,
          },
          modes: {
            bubble: {
              distance: 250,
              duration: 2,
              opacity: 0,
              size: 0,
            },
            push: {
              quantity: 4,
            },
            repulse: {
              distance: 100,
              duration: 0.4,
            },
          },
        },
        particles: {
          color: {
            value: ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"]
          },
          collisions: {
            enable: false,
          },
          move: {
            direction: "top",
            enable: true,
            outModes: {
              default: "out",
            },
            random: false,
            straight: false,
            speed: {
              min: 2,
              max: 4,
            }
          },
          number: {
            density: {
              enable: true,
              area: 800,
            },
            value: 80,
          },
          opacity: {
            value: 0.5,
          },
          shape: {
            type: "circle",
          },
          size: {
            // value: { 100, 200}
            value: { min: 100, max: 150 },
          },
        },
        detectRetina: true,
      });
    }
  }, []);

  return <div className="custm-bg" ref={containerRef} id="tsparticles" />;
};

export default App;
