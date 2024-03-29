const mix = require('laravel-mix')

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

let vendors = [
    'vue',
    'vuex',
    'vee-validate',
    'axios',
    'sweetalert2',
    'lodash',
    'collect.js',
    'http-build-query',
    'vue-currency-filter',
    'vee-validate/dist/locale/pt_BR'
]

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/event/create/main.js', 'public/js/event/create')
    .js('resources/js/event/my-events/main.js', 'public/js/event/my-events')
    .js('resources/js/event/administration/main.js', 'public/js/event/administration')
    .js('resources/js/event/order-manual/main.js', 'public/js/event/order-manual')
    .js('resources/js/auth/header.js', 'public/js/auth')
    // .extract(vendors)

if (mix.inProduction()) {
    mix.sourceMaps().version()
    mix.copyDirectory('resources/seo', 'public')
    mix.disableNotifications()
}

//mix.browserSync('127.0.0.1:8000')
