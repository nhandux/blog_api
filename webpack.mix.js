const mix = require('laravel-mix');

mix.extend(
    "graphql",
    new (class {
        dependencies() {
            return ["graphql", "graphql-tag"];
        }

        webpackRules() {
            return {
                test: /\.(graphql|gql)$/,
                exclude: /node_modules/,
                loader: "graphql-tag/loader"
            };
        }
    })()
);
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/admin/js').vue()
    .postCss('resources/css/app.css', 'public/admin/css', [
        
    ])
    .sass('resources/scss/style.scss', 'public/admin/css');
    
mix.graphql();