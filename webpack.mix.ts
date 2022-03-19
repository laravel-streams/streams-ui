import mix from 'laravel-mix';
import ts from 'typescript';
import '@laravel-streams/mix-extension';
import { execSync } from 'child_process';
import { join } from 'path';
import { rm } from 'shelljs';
import { checkWebpackConfig, modifyWebpackConfig } from 'systemjs-webpack-interop/webpack-config';

mix
.ts('resources/lib/index.ts', '')
// .sass('resources/scss/variables.scss', 'css')
.copyDirectory('resources/public/js', '../../../public/vendor/streams/ui/js')
.sourceMaps(false)
.streams({
    name    : ['streams','ui'],
    analyse : true,
    type    : 'window',
});

if ( mix.inProduction() ) {
    rm('rf', join(__dirname, 'resources/public'));
    mix.copyDirectory('resources/fonts', '../../../public/vendor/streams/ui/fonts');
}

let tsc = require.resolve('typescript').replace('lib/typescript.js', 'bin/tsc');
mix.before(stats => {
    execSync(`${tsc} --project webpack.tsconfig.json --emitDeclarationOnly --declarationDir resources/public/types`, {
        cwd     : __dirname,
        encoding: 'utf8',
    });
});


mix.override(config => {
    // config.experiments.layers            = true;
    // config                               = modifyWebpackConfig(config) as any;
    // checkWebpackConfig(config);
    return config;
});
