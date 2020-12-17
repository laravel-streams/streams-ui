const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix
    .ts('resources/ts/index.ts', 'resources/public/js')
    .sass('resources/scss/theme.scss', 'resources/public/css')
    .sass('resources/scss/variables.scss', 'resources/public/css')
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')],
    }).webpackConfig(

        /**
         * @return webpack.Configuration
         */
        function (webpack) {

            return {
                resolve: {
                    alias: {
                        '@streams/core': 'streams.core',
                    }
                },
                externals: {
                    '@streams/core': ['streams', 'core'],
                },
                plugins: [
                    require('@tailwindcss/ui'),
                ],
                output: {
                    library: ['streams', 'ui'],
                    libraryTarget: 'window'
                }
            };
        }
    );
