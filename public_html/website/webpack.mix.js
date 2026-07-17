const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .react()
    .sass("resources/sass/app.scss", "public/css")
    .styles(["resources/css/style.css"], "public/css/style.css");

// backend
mix.js(
    [
        "resources/backend/js/app.js",
        "resources/backend/plugins/bootstrap/bootstrap.bundle.min.js",
    ],
    "public/backend/js/app.js"
)
    .js("resources/backend/js/adminlte.min.js", "public/backend/js/theme.js")
    .sass("resources/backend/css/app.scss", "public/backend/css/font.css")
    .styles(
        ["resources/backend/css/adminlte.min.css"],
        "public/backend/css/app.css"
    );

mix.sourceMaps().version();
