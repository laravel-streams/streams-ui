let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const {resolve} = require('path');

let isProd = mix.inProduction();
let isDev = !mix.inProduction();


const babelConfig = {
    babelrc   : false,
    configFile: false,

    compact   : isProd,
    sourceMaps: isDev,
    comments  : isDev,
    presets   : [
        ['@babel/preset-env', {
            'useBuiltIns': false,
            'targets'    : '> 0.25%, not dead',
        }],
    ],
    plugins   : [
        '@babel/plugin-syntax-dynamic-import',
    ],
};
const tsConfig = {
    transpileOnly  : true,
    logLevel       : 'INFO',
    logInfoToStdOut: true,
    happyPackMode  : true,
    configFile     : resolve(__dirname, 'webpack.tsconfig.json'),
    compilerOptions: {
        target              : 'es6',
        module              : 'esnext',
        declaration         : false,
        declarationDir      : resolve(__dirname, 'resources/public/types'),
        importHelpers       : true,
        sourceMap           : isDev,
        removeComments      : isProd,
        experimentalWatchApi: true,

    },
};


const webpackConfig = {
    devtool: isProd ? false : 'inline-cheap-module-source-map',

    externals   : {
        '@laravel-streams/core': ['streams', 'core']
    },
    output      : {
        path                                 : resolve('./resources/public'),
        filename                             : 'js/[name].js',
        chunkFilename                        : 'js/chunk.[name].js',
        library                              : ['streams', 'ui'],
        libraryTarget                        : 'window',
        publicPath                           : '/vendor/streams/ui/',
        devtoolFallbackModuleFilenameTemplate: 'webpack:///[resource-path]?[hash]',
        devtoolModuleFilenameTemplate        : info => {
            var $filename = 'sources://' + info.resourcePath;
            $filename = 'webpack:///' + info.resourcePath; // +'?' + info.hash;
            if ( info.resourcePath.match(/\.vue$/) && !info.allLoaders.match(/type=script/) && !info.query.match(/type=script/) ) {
                $filename = 'webpack-generated:///' + info.resourcePath; // + '?' + info.hash;
            }
            return $filename;
        },
    },
    optimization: {
        moduleIds: 'named',
        chunkIds : 'named',
        minimize : isProd,
    },
    experiments : {},
};
if ( process.env.DISABLE_MINIMIZE ) {
    webpackConfig.optimization.minimize = false;
}

mix
    .ts('resources/lib/index.ts', '')
    .sass('resources/scss/variables.scss', 'resources/public/css')
    .sass('resources/scss/tailwind.scss', 'resources/public/css')
    .sass('resources/scss/theme.scss', 'resources/public/css')
    .copyDirectory('resources/public', '../../../public/vendor/streams/ui')
    .options({
        processCssUrls: false,
        postCss       : [tailwindcss('./tailwind.config.js')],
        sourcemaps    : false,
        terser        : {
            terserOptions: {
                keep_classnames: true,
                keep_fnames    : true,
            },
        },
    })
    .babelConfig(babelConfig)
    .webpackConfig(webpackConfig)
    .override((config) => {
        let rule = config.module.rules.find((rule) => rule.loader === require.resolve('ts-loader'));
        delete rule.loader;
        delete rule.options;
        rule.use = [
            {
                loader : 'babel-loader',
                options: babelConfig,
            },
            {
                loader : 'ts-loader',
                options: tsConfig,
            },
        ];
    });
