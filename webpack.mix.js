let mix = require('laravel-mix');
const path = require('path');

mix
    .js('resources/lib/index.js', '')
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .webpackConfig(

        function (webpack) {

            return {
                externals: {
                    '@streams/core': ['streams', 'core'],
                    'axios': ['streams', 'core', 'axios'],
                },
                output: {
                    path: path.resolve('./resources/public'),
                    filename: 'js/[name].js',
                    chunkFilename: 'js/chunk.[name].js',
                    library: ['streams', 'ui'],
                    publicPath: '/vendor/streams/ui/',
                    libraryTarget: 'window'
                }
            };
        })
    .sourceMaps();
