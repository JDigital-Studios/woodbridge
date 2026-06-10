module.exports = {
  content: [
    './dist/**/*.html', 
    './src/**/*.css',
    '*.{html,php,js}',
    './templates/**/*.php',
    './inc/**/*.php',
    './template-parts/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        title: ['futura-pt, sans-serif'],
        text: ['times-new-roman, sans-serif'],
      },
      colors: {
        primary: {
          300: '#DE6762', // pink
          400: '#FFCC5D', // yellow
          500: '#8DAABF', // blue
          600: '#F1BB7F', // orange
          700: '#9A2531', // red
          800: '#050000', // black
        },
      },
      fontSize: {
        '10': '0.625rem',
        '15': '0.938rem',
        '35': '2.188rem',
        '40': '2.5rem',
        '50': '3.125rem',
      },
      letterSpacing: {
        'w': '0.04em',
      },
      zIndex: {
        'negative-1': '-1',
      },
      screens: {
        'md-down': { 'max': '767px' },
        'lg-down': { 'max': '1023px' },
        'xl-down': { 'max': '1199px' }
      },
    },
  },
  variants: {
    extend: {
      
    },
  },
};