import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

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
        tailwindcss(),
    ],
    server: {
        host: "localhost",
        port: 5173,
        hmr: {
            host: "localhost",
        },
    },
});
