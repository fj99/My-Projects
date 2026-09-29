import React, { useRef } from "react";

const cubeFaces = ["UI", "API", "DATA", "AI", "CLOUD", "DEV"];

export default function HeroScene() {
  const sceneRef = useRef(null);

  const handlePointerMove = (event) => {
    const scene = sceneRef.current;
    if (!scene) return;

    const bounds = scene.getBoundingClientRect();
    const x = (event.clientX - bounds.left) / bounds.width - 0.5;
    const y = (event.clientY - bounds.top) / bounds.height - 0.5;

    scene.style.setProperty("--scene-x", `${x * 18}deg`);
    scene.style.setProperty("--scene-y", `${y * -14}deg`);
    scene.style.setProperty("--pointer-x", `${(x + 0.5) * 100}%`);
    scene.style.setProperty("--pointer-y", `${(y + 0.5) * 100}%`);
  };

  const resetScene = () => {
    const scene = sceneRef.current;
    if (!scene) return;
    scene.style.setProperty("--scene-x", "0deg");
    scene.style.setProperty("--scene-y", "0deg");
  };

  return (
    <div
      className="hero-scene"
      ref={sceneRef}
      onPointerMove={handlePointerMove}
      onPointerLeave={resetScene}
      aria-hidden="true"
    >
      <div className="scene-glow" />
      <div className="scene-stage">
        <div className="orbit orbit-one"><span /></div>
        <div className="orbit orbit-two"><span /></div>
        <div className="orbit orbit-three"><span /></div>

        <div className="core-halo" />
        <div className="tech-cube">
          {cubeFaces.map((face, index) => (
            <div key={face} className={`cube-face cube-face-${index + 1}`}>
              <span>{face}</span>
            </div>
          ))}
        </div>

        <div className="scene-panel scene-panel-code">
          <span className="panel-label">system.build()</span>
          <i /><i /><i />
        </div>
        <div className="scene-panel scene-panel-status">
          <span className="status-dot" />
          <span>Systems online</span>
        </div>
        <div className="scene-panel scene-panel-metric">
          <strong>700+</strong>
          <span>clinics connected</span>
        </div>

        <div className="scene-floor">
          <div className="floor-ring" />
        </div>
      </div>
      <p className="scene-hint"><span /> Move to explore</p>
    </div>
  );
}
