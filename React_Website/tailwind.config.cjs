/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{js,jsx,ts,tsx}", "./index.html"],
  theme: {
    extend: {
      colors: {
        ink: "#050816",
        "ink-soft": "#0f172a",
        signal: "#38bdf8",
        ember: "#f59e0b",
      },
      boxShadow: {
        snap: "0 18px 55px rgba(2, 8, 23, 0.34)",
        "snap-soft": "0 14px 35px rgba(15, 23, 42, 0.24)",
      },
    },
  },
  plugins: [],
};
