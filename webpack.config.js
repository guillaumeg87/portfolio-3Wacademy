const webpack = require("webpack");
const path = require("path");
const devMode = process.env.NODE_ENV !== 'production';
const MiniCssExtractplugin = require("mini-css-extract-plugin");
const OptimizeCSSAssets = require("optimize-css-assets-webpack-plugin");
const UglifyJSPlugin = require("uglifyjs-webpack-plugin");
const DashboardPlugin = require("webpack-dashboard/plugin");

let config = {
    entry: "./App/Assets/js/index.js",
    output: {
        path: path.resolve(__dirname, "./App/web/public"),
        filename: "./bundle.js"
    },
    module: {
        rules: [
        {
            test: /\.js$/,
            exclude: /node_modules/,
            loader: "babel-loader",

        },
            {

                test: /\.scss$/,
                use: [
                    'css-hot-loader',
                    MiniCssExtractplugin.loader,
                    'css-loader',
                    'sass-loader',
                    'postcss-loader'
                ]
            }
            ]
    },
    plugins: [
        new MiniCssExtractplugin({
            filename: devMode ? '/[name].css' : '[name].min.css',
        }),
        new DashboardPlugin(),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery"
        })
    ],
    devServer: {
        contentBase: path.join(__dirname, 'dist'),
        compress: true,
        port: 8080
    },
    mode: 'development'
}

module.exports = config;

if (process.env.NODE_ENV === 'production') {
    module.exports.plugins.push(
        new UglifyJSPlugin(),
        new OptimizeCSSAssets()
    );
}