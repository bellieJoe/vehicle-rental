module.exports = {
  prefix: 'tw-', // Adds a prefix to all Tailwind classes
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  corePlugins: {
    preflight: false, // Disables Tailwind's base styles (Preflight)
  },
};
