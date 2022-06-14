const mix = require('laravel-mix')
require('dotenv').config()

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

// ADMIN
mix.js('resources/js/admin/admin.js', 'public/dist/admin/js')
    .vue()



    // .sass('resources/sass/admin/admin.scss', 'public/dist/admin/css')

// FRONT
// mix.options({
//     processCssUrls: false
// });
//
// mix.js(`resources/js/front/front.js`, 'public/dist/front/js')
//     .vue()

// mix.sass(`resources/sass/front/app.scss`, 'public/dist/front/css/main.css')

// karox em heto ogtagorcel kam Xoreni pes time
// ()

// if (mix.inProduction()) {
//     mix.version();
// }

