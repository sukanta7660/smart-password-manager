let mix = require('laravel-mix');

mix.js('assets/js/main.js', 'public/js').vue({ version: 3 }).setPublicPath('public');