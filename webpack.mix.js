const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('resources/src/index.js', 'resources/public/js')
    .sass('resources/src/scss/theme.scss', 'resources/public/css')
    .sass('resources/src/scss/variables.scss', 'resources/public/css');

mix.copyDirectory('resources/public', '../../../public/vendor/streams/ui');

mix.options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')],
});

mix.webpackConfig({
    plugins: [],
});

// mix.browserSync({
//     proxy: process.env.APP_URL,
//     files: [
//         'public/js/**/*.js',
//         'public/css/**/*.css',
//         'resources/views/**/*.html',
//         'resources/views/**/*.php',
//         'streams/**/*.json',
//         'streams/**/*.md'
//     ],
//     notify: false
// });


//mix.version();

// Purge css 
// if (mix.inProduction()) {
//     mix.sourceMaps().version();
// }
