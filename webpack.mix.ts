import mix from 'laravel-mix';
import '@laravel-streams/mix-extension';

mix
.ts('resources/lib/index.ts','resources/public/js')
.sass('resources/scss/variables.scss', 'resources/public/css')
// .sass('resources/scss/tailwind.scss', 'resources/public/css')
// .sass('resources/scss/theme.scss', 'resources/public/css')
.copyDirectory('resources/public', '../../../public/vendor/streams/ui')
// .copyDirectory('resources/fonts', '../../../public/vendor/streams/ui/fonts')
.options({
    processCssUrls: false,
    // postCss       : [require('tailwindcss')('./tailwind.config.js')],
    sourcemaps: false,
})
.streams({
    name   : [ 'streams', 'ui' ],
    analyse: true,
    type   : 'window',
});

mix.override(config => {
    return config;
});


if ( !mix.inProduction() ) {
    mix.sourceMaps();
}



