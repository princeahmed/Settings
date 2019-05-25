const path = require('path');
const modeConfig = env => require(`./src/build-utils/webpack.${env}`)(env);
const webpackMerge = require('webpack-merge');
const cleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = ({mode} = {mode: 'development'}) => {

    return webpackMerge({
        mode,

        entry: {
            prince: __dirname + '/src/prince.js'
        },

        output: {
            path: path.resolve(__dirname, './assets'),
            filename: '[name].min.js'
        },

        plugins: [
            new cleanWebpackPlugin(),
            new MiniCssExtractPlugin({filename: '[name].min.css'})
        ]

    }, modeConfig(mode));
};