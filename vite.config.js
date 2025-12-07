import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: [
                "resources/views/**/*.blade.php",
                "app/View/Components/**/*.php",
                "app/Livewire/**/*.php",
                "resources/js/**/*.js",
            ],
        }),
    ],
    build: {
        manifest: "manifest.json", // Keep manifest at root of build directory
        outDir: "public/build",
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
});
