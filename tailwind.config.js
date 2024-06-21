/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    safelist: [
        {
            pattern: /text-(green-red)-(400|800|600)/
        },
        {
            pattern: /bg-(green)-(50)/
        }
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
