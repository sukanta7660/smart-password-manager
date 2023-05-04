let mix = require('laravel-mix');

mix
    .js('assets/js/main.js', 'public/js').vue({ version: 3 })
    .sass('assets/scss/custom.scss', 'css')
    .setPublicPath('public');