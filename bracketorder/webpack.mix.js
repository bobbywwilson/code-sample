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

mix.js('resources/assets/js/mobile/app.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/basic-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/bollinger-bands-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/macd-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/rsi-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/stochastic-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/bmrs-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/bmr-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/bm-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/brs-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/br-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/mrs-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/mr-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/ms-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/rs-chart.js', 'public/js/mobile')
    .js('resources/assets/js/charts/mobile/bs-chart.js', 'public/js/mobile')
    .js('resources/assets/js/app-login.js', 'public/js/mobile');

mix.sass('resources/assets/sass/app.scss', 'public/mobile/css')
    .sass('resources/assets/sass/app-auth.scss', 'public/css');

mix.styles([
    'resources/assets/css/mobile/stylesheet.css',
], 'public/css/mobile/all.css');

// mix.styles([
//     'resources/assets/css/stylesheet-desktop.css',
//     'resources/assets/css/responsive-desktop.css',
// ], 'public/css/desktop-all.css');

// mix.styles([
//     'resources/assets/css/stylesheet-mobile.css',
//     'resources/assets/css/responsive-mobile.css',
// ], 'public/css/mobile-all.css');