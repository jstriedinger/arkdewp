const path = require( 'path' )
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' )
const CopyWebpackPlugin = require( 'copy-webpack-plugin' )

const config = {
	context: path.resolve( __dirname, 'src' ),
	// configurations here
	entry: {
		arkdewp: './js/index.js',
	},
	output: {
		filename: './js/[name].js',
		// Output path using nodeJs path module
		path: path.resolve( __dirname, 'assets' ),
	},
	// Adding jQuery as external library
	externals: {
		jquery: 'jQuery',
	},
	module: {
		rules: [
			{
				test: /\.s[ac]ss$/i,
				use: [
					MiniCssExtractPlugin.loader,
					{ loader: 'css-loader', options: { url: false, sourceMap: true } },
					{ loader: 'postcss-loader' },
					{ loader: 'sass-loader', options: { sourceMap: true } },
				],
			},
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: [
					{
						loader: 'babel-loader',
						options: {
							presets: [ '@babel/preset-env' ],
							cacheDirectory: true,
						},
					},
				],
			},
		],
	},
	plugins: [
		new CopyWebpackPlugin( {
			patterns: [
				{ from: 'webfonts', to: 'webfonts' },
				{ from: 'img', to: 'img' },
			],
		} ),
	],
}

module.exports = config
