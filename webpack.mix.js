const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const path = require('path');

const isDev = process.env.NODE_ENV === 'development';

mix
    .sass('resources/scss/theme.scss', 'css')
    .sass('resources/scss/variables.scss', 'css')
    .ts('resources/ts/index.ts', '')
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
                    {
                        apply(compiler) {
                            compiler.hooks.entryOption.tap('streams',(ctx, entry) => {
                                    let imports = entry['/index']['import'];
                                    entry['/index']['import'] = imports.reverse();
                                });
                        }
                    }
                ],
                externals: {
                    '@streams/core': ['streams', 'core'],
                    'axios': ['streams', 'core', 'axios'],
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
