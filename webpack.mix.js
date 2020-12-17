const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.ts('resources/ts/index.ts', 'resources/public/js', {

    })
    .sass('resources/scss/theme.scss', 'resources/public/css')
    .sass('resources/scss/variables.scss', 'resources/public/css');

mix.copyDirectory('resources/public', '../../../public/vendor/streams/ui');

mix.options({
    processCssUrls: false,
    postCss       : [tailwindcss('./tailwind.config.js')],
});

mix.webpackConfig(
    /**
     * @return webpack.Configuration
     * */
    function (webpack) {

        return {
            resolve: {
                alias: {
                    '@streams/core': 'streams.core',
                    '@streams/ui'  : 'streams.ui',
                }
            },
            externals: {
                '@streams/core': 'streams.core',
                '@streams/ui'  : 'streams.ui',
            },
            plugins  : [
                require('@tailwindcss/ui'),
            ],
            output   : {
                library      : ['streams','ui'],
                libraryTarget: 'window'
            }
        };
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
