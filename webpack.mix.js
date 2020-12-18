const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');


const isDev = process.env.NODE_ENV === 'development';

mix
    .ts('resources/ts/index.ts', 'resources/public/js')
    .ts('resources/scss/theme.scss', 'resources/public/css')
    .ts('resources/scss/variables.scss', 'resources/public/css')
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')],
    })
    .webpackConfig(
        /**
         * @return webpack.Configuration
         */
        function (webpack) {

            return {
                devtool: isDev ? '#source-map' : null,
                plugins: [
                    require('@tailwindcss/ui'),
                ],
                externals: {
                    '@streams/core': ['streams', 'core'],
                },
                output: {
                    library: ['streams', 'ui'],
                    libraryTarget: 'window',
                    devtoolFallbackModuleFilenameTemplate: 'webpack:///[resource-path]?[hash]',
                    devtoolModuleFilenameTemplate: info => {
                        var $filename = 'sources://' + info.resourcePath;
                        $filename = 'webpack:///' + info.resourcePath; // +'?' + info.hash;
                        if (info.resourcePath.match(/\.vue$/) && !info.allLoaders.match(/type=script/) && !info.query.match(/type=script/)) {
                            $filename = 'webpack-generated:///' + info.resourcePath; // + '?' + info.hash;
                        }
                        return $filename;
                    }
                }
            };
        }
    )
    .sourceMaps();
