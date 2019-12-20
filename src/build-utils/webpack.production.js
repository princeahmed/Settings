const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FileManagerPlugin = require('filemanager-webpack-plugin');

module.exports = () => ({

    module: {
        rules: [
            {
                test: /\.s?css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
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
                    'sass-loader'
                ]
            },
            {
                test: /\.(jpe?g|png|gif|ttf|eot|svg|woff)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]'
                }
            },
            {
                test: /\.(ttf|eot|svg|woff)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]'
                }
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: '/node_modules/'
            }
        ]
    },

    plugins: [
        new webpack.LoaderOptionsPlugin({
            minimize: true
        }),

        new FileManagerPlugin({
            onStart: {
                delete: ['./build']
            },

            onEnd: {
                copy: [
                    {source: './assets', destination: './build/assets'},
                    {source: './includes', destination: './build/includes'},
                    {source: './demo', destination: './build/demo'},
                    {source: './*.php', destination: './build'}
                    //todo uncomment when need css & js editor
                    //{source: './src/vendor/ace.min.js', destination: './assets/ace.min.js'}
                ],

                archive: [
                    {source: './build', destination: `./build/prince-settings.zip`}
                ]
            }
        })
    ]

});