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

mix.js('resources/js/app.js', 'public/js')
    //.sass('resources/assets/sass/style.scss', 'public/css')
    .combine([
        'resources/vendor/jquery/jquery.min.js',
        'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'resources/vendor/jquery-easing/jquery.easing.min.js',
        'resources/vendor/select2/dist/js/select2.full.js',
        'resources/vendor/select2/dist/js/i18n/ru.js',
        'resources/js/howler.core.js',
        'resources/vendor/fancybox-master/dist/jquery.fancybox.min.js',
        'resources/js/ruang-admin.js',
        'resources/js/app.js',
    ],'public/js/app.js')
    .combine([
        'resources/vendor/fontawesome-free/css/all.min.css',
        'resources/vendor/bootstrap/css/bootstrap.min.css',
        'resources/vendor/select2/dist/css/select2.min.css',
        'resources/vendor/select2/dist/css/select2-bootstrap4.min.css',
        'resources/vendor/fancybox-master/dist/jquery.fancybox.min.css',
        'resources/css/ruang-admin.min.css',
        'resources/css/main.css',
    ],'public/css/all.css')
    .version()
    .minify(['public/js/app.js','public/css/all.css'])
    .copyDirectory('resources/vendor/public/font', 'public/font')
    .copyDirectory('resources/vendor/public/img', 'public/img')
    .copyDirectory('resources/vendor/public/sound', 'public/sound')
    .copyDirectory('resources/vendor/public/webfonts', 'public/webfonts');
