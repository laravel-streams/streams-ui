const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.ts('resources/ts/index.ts', 'resources/public/js', {});

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
            resolve  : {
                alias: {
                    '@streams/core': 'streams.core',
                }
            },
            externals: {
                '@streams/core': ['streams', 'core'],
            },
            plugins  : [
                require('@tailwindcss/ui'),
            ],
            output   : {
                library      : ['streams', 'ui'],
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
