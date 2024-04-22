/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./*.html"
  ],
  theme: {
    extend: {
      colors: {
        'my-purple': '#5c5470',
      },
      backgroundImage: {
        'custom-gradient': 'linear-gradient(180.2deg, rgb(30, 33, 48) 6.8%, rgb(74, 98, 110) 131%)',
      },
    },
  },
  plugins: [],
}

