/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist: [
    // Ensure these color classes are always generated
    'bg-primary',
    'bg-primary-dark',
    'bg-primary-light',
    'bg-primary-50',
    'bg-primary-100',
    'bg-primary-600',
    'bg-primary-700',
    'text-primary',
    'text-primary-dark',
    'text-primary-light',
    'text-primary-50',
    'text-primary-100',
    'text-primary-600',
    'text-primary-700',
    'border-primary',
    'border-primary-dark',
    'text-charcoal',
    'bg-charcoal',
    'bg-gray-soft',
    'text-gray-medium',
    'bg-accent-dark',
    'bg-accent-navy',
    'bg-accent-teal',
    'hover:bg-primary-dark',
    'hover:text-primary-dark',
    'hover:text-primary',
    'focus:ring-primary',
    'focus:border-primary',
    'shadow-green',
  ],
  theme: {
    extend: {
      colors: {
        // Primary Green (from image)
        'primary': '#10B981', // Bright emerald green
        'primary-dark': '#059669', // Darker green for hover
        'primary-light': '#34D399', // Lighter green for accents
        'primary-50': '#ECFDF5',
        'primary-100': '#D1FAE5',
        'primary-600': '#059669',
        'primary-700': '#047857',
        // Secondary Colors
        'charcoal': '#1F2937', // Dark gray for text
        'gray-soft': '#F9FAFB', // Soft gray background
        'gray-medium': '#6B7280', // Medium gray
        // Accent Colors
        'accent-navy': '#1E3A8A', // Deep navy blue
        'accent-teal': '#0D9488', // Dark teal
        'accent-dark': '#111827', // Near black
        // Extended Palette (Ultra-Premium)
        'emerald': {
          '900': '#1a472a',
          '700': '#2d6a4f',
          '500': '#40916c',
        },
        'gold': {
          '800': '#b8941f',
          '600': '#d4af37',
          '400': '#f9d976',
        },
        'coral': {
          '500': '#FF6B6B',
          '300': '#FF9E9E',
        },
        'neutral': {
          '900': '#2d3748',
          '400': '#718096',
        },
      },
      fontFamily: {
        'sans': ['Inter', 'Poppins', 'Open Sans', 'system-ui', 'sans-serif'],
        'urdu': ['Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', 'serif'],
      },
      boxShadow: {
        'soft': '0 2px 8px rgba(0, 0, 0, 0.06)',
        'medium': '0 4px 16px rgba(0, 0, 0, 0.08)',
        'strong': '0 8px 24px rgba(16, 185, 129, 0.12)',
        'green': '0 4px 12px rgba(16, 185, 129, 0.15)',
        'ultra-soft': '0 6px 30px rgba(26, 71, 42, 0.06)',
      },
      borderRadius: {
        'card': '12px',
        'button': '10px',
        'input': '10px',
        'ultra': '12px',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}

