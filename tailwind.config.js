/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        clifford: '#da373d',
        custom_yellow: '#ffda00'
      }
    },
  },
  plugins: [],
}