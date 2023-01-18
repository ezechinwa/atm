// module.exports = {
//   plugins: {
//     tailwindcss: {},
//     autoprefixer: {},
//   },
// }

// let tailwindcss = require('tailwindcss');
// module.exports = {
//   plugins: [
//     tailwindcss('./tailwind.config.js'),
//     require('postcss-import'),
//     require('autoprefixer')
//   ],
// }

module.exports = {
  plugins: [
    // ...
    require('tailwindcss'),
    require('autoprefixer'),
    // ...
  ]
}