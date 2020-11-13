const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .scripts([
        'resources/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
        'resources/adminlte/js/adminlte.min.js',
        'resources/adminlte/plugins/jquery-mousewheel/jquery.mousewheel.js',
        'resources/adminlte/plugins/raphael/raphael.min.js',
        'resources/adminlte/plugins/jquery-ui/jquery-ui.min.js',
        'resources/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js',
    ], 'public/js/vendor.js')
    .styles([
        'resources/adminlte/plugins/fontawesome-free/css/all.min.css',
        'resources/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
        'resources/adminlte/css/adminlte.min.css',
        'resources/adminlte/plugins/jquery-ui/jquery-ui.min.css',
    ], 'public/css/vendor.css')
    .copyDirectory('resources/adminlte/plugins/fontawesome-free/webfonts', 'public/webfonts')
    .copyDirectory('resources/adminlte/plugins/jquery-ui/images', 'public/css/images');
