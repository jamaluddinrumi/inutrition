const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    important: true,
    purge: [
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue"
    ],

    darkMode: false, // or 'media' or 'class'

    theme: {
        extend: {
            fontFamily: {
                sans: ["IBM Plex Sans", ...defaultTheme.fontFamily.sans]
            }
        }
    },

    variants: {
        opacity: ["responsive", "hover", "focus", "disabled"]
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@tailwindcss/aspect-ratio")
    ],

    corePlugins: {
        preflight: false
    }
};
