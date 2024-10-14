let mix = require("laravel-mix");

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.json'],
    },
    stats: {
        children: true
    }
});

mix.options({
    processCssUrls: false,
    clearConsole: true,
    terser: {
        extractComments: false,
    },
    manifest: false,
});

mix.disableSuccessNotifications();


mix
    .setPublicPath("public")
    .autoload({
        jquery: ['$', 'window.jQuery', 'window.$'],
    })
    .js(
        "resources/assets/js/common.js",
        "public/build/js/common.js"
    )
    .sass(
        "resources/assets/sass/common.scss",
        "public/build/css/common.css"
    );
