module.exports = {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/asantibanez/livewire-calendar/resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", "ui-sans-serif", "system-ui", "sans-serif"],
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
