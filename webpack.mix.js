let mix = require('laravel-mix');

mix
    .js('assets/js/main.js', 'public/js').vue({ version: 3 })
    .js('assets/frontend/main.js', 'public/frontend').vue({ version: 3 })
    .sass('assets/scss/custom.scss', 'css')
    .sass('assets/scss/frontend.scss', 'css')
    .setPublicPath('public');