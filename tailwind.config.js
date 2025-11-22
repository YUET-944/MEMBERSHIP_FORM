/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'primary-green': '#1e4d2b',
        'secondary-green': '#2d6a4f',
        'accent-green': '#40916c',
        'light-green': '#52b788',
        'accent-gold': '#d4af37',
        'accent-coral': '#ff6b6b',
        'cream': '#faf8f3',
        'light-gray': '#f5f5f5',
        'dark': '#2c3e50',
        'gray': '#6c757d',
      },
      fontFamily: {
        'urdu': ['Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', 'serif'],
      },
    },
  },
  plugins: [],
}

