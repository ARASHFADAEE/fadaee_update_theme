/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./src/**/*.{html,js,php}",
    "./templates/**/*.php",
    "./inc/**/*.php"
  ],
    safelist: [
        'sm:-mx-8',
        '-mx-4',
    ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        sans: ['IRANYekan', 'Tahoma', 'Arial', 'sans-serif'],
      },
      animation: {
        'avatar-shrink': 'avatarShrink 0.5s ease-out forwards'
      },
      keyframes: {
        avatarShrink: {
          '0%': { transform: 'scale(1) translateY(0)', opacity: '1' },
          '100%': { transform: 'scale(0.7) translateY(-40px)', opacity: '1' }
        }
      }
    }
  },
  plugins: []
}