const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.postCss('resources/css/app.css', 'public/assets/css', [
        require('tailwindcss')
    ])
    .postCss('resources/css/tailwind.css', 'public/assets/css', [require('tailwindcss')])
    .postCss('resources/css/sb-admin-2.css', 'public/assets/css', [])
    .postCss('resources/css/sb-admin-2.min.css', 'public/assets/css', [])
    // .js('resources/js/app.js', 'public/assets/js')
