const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const path = require('path');

const isDev = process.env.NODE_ENV === 'development';

mix
    .ts('resources/ts/index.ts', 'resources/js')
    // .sass('resources/scss/theme.scss', 'resources/css')
    // .sass('resources/scss/variables.scss', 'resources/css')
    // .sass('resources/scss/inputs/markdown.scss', 'resources/css/inputs')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')],
    })
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .webpackConfig(
        function (webpack) {
            return {
                //devtool: isDev ? 'hidden-source-map' : false,
                plugins: [
                    require('@tailwindcss/ui'),
                ],

                externals: {
                    '@streams/core': ['streams', 'core'],
                },
                output: {

                    //path: path.resolve('./resources/public'),
                    //filename: 'js/[name].js',
                    //chunkFilename: 'js/chunk.[name].js',
                    library: ['streams', 'ui'],
                    //publicPath: '/vendor/streams/ui/',
                    libraryTarget: 'window',
                }
            };
        }
    )
    .sourceMaps();
