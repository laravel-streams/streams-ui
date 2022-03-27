// require('ts-node/register/transpile-only');
// require('./webpack.mix.ts');

let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix
    .js('resources/lib/index.js', 'resources/public/js')
    .sass('resources/scss/variables.scss', 'resources/public/css')
    .sass('resources/scss/tailwind.scss', 'resources/public/css')
    .sass('resources/scss/theme.scss', 'resources/public/css')
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')],
    })
    .webpackConfig(

        function (webpack) {

            return {
                externals: {
                    '@streams/core': ['streams', 'core'],
                    'axios': ['streams', 'core', 'axios'],
                },
                output: {
                    library: ['streams', 'ui'],
                    libraryTarget: 'window',
                }
            };
        })
    // .override(config => {
    //     config.entry['/resources/public/js/index'] = config.entry['/resources/public/js/index'].reverse()
    // })
    .sourceMaps();
