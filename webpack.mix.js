let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .copy('/var/www/zubroid/gitpab/node_modules/moment/min/moment-with-locales.js', 'public/js/moment-with-locales.js')
   .sass('resources/assets/sass/app.scss', 'public/css');
