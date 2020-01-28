let mix = require('laravel-mix');
// let mix = require('laravel-mix-tailwind');
let tailwindcss = require('tailwindcss');

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    });