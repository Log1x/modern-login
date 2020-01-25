module.exports = {
  theme: {
    extend: {
      fontSize: {
        'none': '0',
      },
      colors: {
        default: 'var(--login-text, #fff)',
        brand: 'var(--login-brand, #0073aa)',
        trim: {
          default: 'var(--login-trim, #191919)',
          alt: 'var(--login-trim-alt, #282828)',
        },
      }
    }
  },
  variants: {},
  plugins: [
    ({ addUtilities }) => {
      addUtilities({
        '.indent-none': {
          'text-indent': '0',
        },
        '.bg-none': {
          'background-image': 'none',
        },
      }, ['responsive'])
    }
  ]
}
