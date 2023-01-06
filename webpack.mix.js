const mix = require('laravel-mix');
const webpack = require('webpack');

mix.webpackConfig({
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery'
      })
    ]
  });
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
    .postCss('resources/css/main.css', 'public/css')
    .version()
    .minify(['public/js/app.js', 'public/css/main.css'])
    .copyDirectory('resources/vendor/public/img', 'public/img')
    .copyDirectory('resources/vendor/public/sound', 'public/sound');
