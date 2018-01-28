let mix = require('laravel-mix');
require('laravel-mix-purgecss');

if (mix.inProduction()) mix.version();

mix.js('resources/assets/js/app.js', 'public/js')
  .postCss('resources/assets/css/app.css', 'public/css')
  .options({
    postCss: [
      require('postcss-import')(),
      require('tailwindcss')('./tailwind.js'),
      require('postcss-cssnext')({
        features: { autoprefixer: false }
      }),
    ]
  })
  .purgeCss();
