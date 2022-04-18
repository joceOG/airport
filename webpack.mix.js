const mix = require('laravel-mix')
require('vuetifyjs-mix-extension')
const path = require('path')

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
mix.alias({
    '@': path.resolve('resources/js')
})
mix.ts('resources/js/app.ts', 'public/js')
    .vuetify('vuetify-loader/dist/plugin')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
