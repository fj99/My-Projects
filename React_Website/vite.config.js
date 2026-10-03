import { defineConfig, transformWithEsbuild } from "vite";
import react from "@vitejs/plugin-react";
import projectContentPlugin from "./scripts/project-content-plugin.mjs";

export default defineConfig({
  base: "/My-Projects/",
  plugins: [
    projectContentPlugin(),
    {
      name: "load-js-as-jsx",
      async transform(code, id) {
        if (!id.match(/src\/.*\.js$/)) {
          return null;
        }

        return transformWithEsbuild(code, id, {
          loader: "jsx",
          jsx: "automatic",
        });
      },
    },
    react(),
  ],
  build: {
    outDir: "build",
    chunkSizeWarningLimit: 700,
  },
});
