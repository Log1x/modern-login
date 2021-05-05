const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

mix.setPublicPath('./public');

mix.postCss('assets/css/login.css', 'public/css', [require('tailwindcss')('./tailwind.config.js'), require('precss')()]).version();

mix.browserSync({
  proxy: 'localhost:8080',
  startPath: 'wp-login.php',
  files: 'public/css/login.css',
});
