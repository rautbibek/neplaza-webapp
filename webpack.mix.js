const mix = require('laravel-mix');

// vue.config.js

const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
const CaseSensitivePathsPlugin = require('case-sensitive-paths-webpack-plugin');

// mix.extend('vuetify', new class {
//     webpackConfig (config) {
//         config.plugins.push(new VuetifyLoaderPlugin())
//     }
// })
 var webpackConfig = {
     plugins: [
         new VuetifyLoaderPlugin(),
         new CaseSensitivePathsPlugin()
     ],
 }
mix.webpackConfig(webpackConfig);


mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');