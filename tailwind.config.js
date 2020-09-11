module.exports = {
  theme: {
    extend: {
      fontSize: {
        none: '0',
      },
      colors: {
        brand: {
          default: 'var(--login-brand, #0073aa)',
          invert: 'var(--login-brand-invert, #fff)',
        },
        trim: {
          default: 'var(--login-trim, #191919)',
          alt: 'var(--login-trim-alt, #282828)',
          invert: 'var(--login-trim-invert, #fff)',
          'alt-invert': 'var(--login-trim-alt-invert, #fff)',
        },
      },
    },
  },
  variants: {},
  plugins: [
    ({ addUtilities }) => {
      addUtilities(
        {
          '.indent-none': {
            'text-indent': '0',
          },
          '.bg-none': {
            'background-image': 'none',
          },
        },
        ['responsive']
      );
    },
  ],
};
