let mix = require('laravel-mix');
require('laravel-mix-purgecss');

if (mix.inProduction()) mix.version();

mix.js('resources/assets/js/app.js', 'public/js')
  .less('resources/assets/less/app.less', 'public/css')
  .options({
    postCss: [
      require('tailwindcss')('./tailwind.js'),
    ]
  })
  .purgeCss();
