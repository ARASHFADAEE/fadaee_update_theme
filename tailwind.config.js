/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.html", "./src/**/*.{html,js}"],
  darkMode: 'class',
  theme: {
    extend: {
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