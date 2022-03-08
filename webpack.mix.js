let mix = require('laravel-mix');
require('@laravel-streams/mix-extension');

mix
    .ts('resources/lib/index.ts', '')
    .sass('resources/scss/variables.scss', 'resources/public/css')
    .sass('resources/scss/tailwind.scss', 'resources/public/css')
    .sass('resources/scss/theme.scss', 'resources/public/css')
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .options({
        processCssUrls: false,
        postCss       : [require('tailwindcss')('./tailwind.config.js')],
        sourcemaps    : false,
    })
    .streams({
        name: ['streams', 'ui']
    });

mix.override(config => {
    return config;
})

if ( !mix.inProduction() ) {
    mix.sourceMaps();
}



