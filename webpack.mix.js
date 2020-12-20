const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const path = require('path');

const isDev = process.env.NODE_ENV === 'development';

mix
    .ts('resources/ts/index.ts', '')
    .ts('resources/ts/css/theme.ts', 'css')
    .ts('resources/ts/css/variables.ts', 'css')
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .options({
        processCssUrls: false,
        postCss       : [tailwindcss('./tailwind.config.js')],
    })
    .webpackConfig(
        function (webpack) {
            return {
                devtool: isDev ? 'hidden-source-map' : false,
                plugins: [
                    require('@tailwindcss/ui'),
                ],

                externals: {
                    '@streams/core': ['streams', 'core'],
                },
                output   : {

                    path                                 : path.resolve('./resources/public'),
                    filename                             : 'js/[name].js',
                    chunkFilename                        : 'js/chunk.[name].js',
                    library                              : ['streams', 'ui'],
                    publicPath                           : '/vendor/streams/ui/',
                    libraryTarget                        : 'window',
                    devtoolFallbackModuleFilenameTemplate: 'webpack:///[resource-path]?[hash]',
                    devtoolModuleFilenameTemplate        : info => {
                        var $filename = 'sources://' + info.resourcePath;
                        $filename = 'webpack:///' + info.resourcePath; // +'?' + info.hash;
                        if ( info.resourcePath.match(/\.vue$/) && !info.allLoaders.match(/type=script/) && !info.query.match(/type=script/) ) {
                            $filename = 'webpack-generated:///' + info.resourcePath; // + '?' + info.hash;
                        }
                        return $filename;
                    }
                }
            };
        }
    )
    .sourceMaps();
