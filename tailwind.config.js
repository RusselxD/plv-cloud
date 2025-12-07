/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",

        // REQUIRED FOR LIVEWIRE
        "./app/Http/Livewire/**/*.php",
        "./resources/views/livewire/**/*.blade.php",
    ],
};
