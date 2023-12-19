/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './*.php',
    './src/**/*.js',
    './js/*.js',
  ],
  watch: [
    './**/*.php',
    './*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Montserrat', 'sans-serif'],
        lora: ['Lora', 'serif'],
      },
      fontSize: {
        base: '1.6rem',
      },
      colors: {
        teal: {
          DEFAULT: '#5D8C92',
        }
      },
      boxShadow: {
        'theme': '0px 6px 16px 0 rgba(0, 0, 0, .1)',
      }
    },
  },
  plugins: [],
}
