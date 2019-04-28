const webpack = require('webpack');
const path = require('path');
const glob = require('glob-all');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const PurgecssPlugin = require('purgecss-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');

//project Mode Development|Production
const mode = 'development';

module.exports = {

    mode: mode,
    entry: { prince: __dirname + '/src/prince.js' },

    output: {
        filename: '[name].min.js' ,
        path: path.resolve(__dirname, './assets')
    },

    module: {
        rules: [
            {
                test: /\.css$/,
                use: ExtractTextPlugin.extract({
                    use: [
                        'css-loader',
                        // Loader for webpack to process CSS with PostCSS
                        {
                            loader: 'postcss-loader',
                            options: {
                                plugins: function () {
                                    return [
                                        require('autoprefixer')
                                    ];
                                }
                            }
                        },
                        // Loads a SASS/SCSS file and compiles it to CSS
                        'sass-loader'
                    ],
                    fallback: 'style-loader'
                })
            },
            {
                test: /\.(jpg|png|gif|ttf|eot|svg|woff)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]'
                        }
                    },
                    {
                        loader: 'image-webpack-loader',
                    }
                ]
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader'
            }
        ]
    },

    plugins: [

        new ExtractTextPlugin('[name].min.css'),

        new webpack.LoaderOptionsPlugin({
            minimize: true
        }),

        new PurgecssPlugin({
            paths: glob.sync(['./src/js/ot-admin.js', './includes/*.php'])
        }),

        new CleanWebpackPlugin({
            root: __dirname,
            verbose: true,
            dry: false,
            cleanStaleWebpackAssets: true,
            watch: false
        })

    ]
};