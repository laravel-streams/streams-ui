const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix
    .ts('resources/ts/index.ts', 'resources/public/js')
    // .sass('resources/scss/theme.scss', 'resources/public/css')
    // .sass('resources/scss/variables.scss', 'resources/public/css')
    // .sass('resources/scss/inputs/markdown.scss', 'resources/public/css/inputs')
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')],
    })
    .webpackConfig(
        function (webpack) {
            return {

                plugins: [
                    require('@tailwindcss/ui'),
                ],

                externals: {
                    '@streams/core': ['streams', 'core'],
                },

                output: {

                    library: ['streams', 'ui'],
                    libraryTarget: 'window',

                    //path: path.resolve('./resources/public'),
                    //filename: 'js/[name].js',
                    //chunkFilename: 'js/chunk.[name].js',
                    //publicPath: '/vendor/streams/ui/',
                }
            };
        }
    )
    .sourceMaps();
