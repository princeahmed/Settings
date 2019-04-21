const webpack = require('webpack');
const path = require('path');
const glob = require('glob');
const pkg = require('./package.json');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const PurgecssPlugin = require('purgecss-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const FileManagerPlugin = require('filemanager-webpack-plugin');
const wpPot = require('wp-pot');

//project Mode Development|Production
const mode = 'development';

//run only on --build command
const build = process.argv[2] === '--build' ? new FileManagerPlugin({
    onEnd: {
        copy: [
            { source: './src', destination: './build' }
        ],
        archive: [
            { source: './src/images', destination: './build/images.zip' }
        ]
    }
}) : () => {return false};

const wppot = process.argv[2] === '--build' ? () => {
    new wpPot({
        destFile: 'file.pot',
        domain: 'domain',
        package: 'Example project',
    });
} : () => {return false};

module.exports = {
    mode: mode,
    entry: {
        public: [
           __dirname + '/src/css/ot-admin.css'
        ]
    },

    output: {
        filename: mode === 'production' ? '[name].min.js' : '[name].[chunkhash].js',
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
                test: /\.(jpg|png|gif)$/,
                use: [
                    {
                        loader: mode === 'production' ? 'url-loader' : 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            limit: mode === 'production' ? 8192 : false
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

        new ExtractTextPlugin(mode === 'production' ? '[name].min.css' : '[name].[chunkhash].css'),

        new webpack.LoaderOptionsPlugin({
            minimize: mode === 'production'
        }),

        new PurgecssPlugin({
            paths: glob.sync('**/*.php')
        }),

        new CleanWebpackPlugin({
            root: __dirname,
            verbose: true,
            dry: false,
            cleanStaleWebpackAssets: true,
            watch: false
        }),

        function () {
            this.plugin('done', stats => {
                require('fs').writeFileSync(
                    path.join(__dirname, 'assets/manifest.json'),
                    JSON.stringify(stats.toJson().assetsByChunkName)
                );
            });
        }

       // build,

       // wppot


    ]
};