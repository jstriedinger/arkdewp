const path = require( 'path' );
const { merge } = require( 'webpack-merge' );
const common = require( './webpack.common.js' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const BS = require( 'browser-sync-webpack-plugin' );

module.exports = merge( common, {
	output: {
		filename: '[name].js',
		path: path.resolve( __dirname, 'assets' ),
	},
	module: {
		rules: [
			{
				test: /\.(png|jpe?g|svg)$/i,
				include: [
					path.resolve( __dirname, 'src/img' ),
				],
				use: [
					{ loader: 'file-loader', options: { name: '[name].[ext]', outputPath: 'img' } },
				],
			},
		],
	},
	mode: 'development',
	devtool: 'inline-source-map',
	watch: true,
	watchOptions: {
		ignored: /node_modules/,
	},
	plugins: [
		new MiniCssExtractPlugin( { filename: '[name].css' } ),
		new BS( {
			files: [
				'./**/*.php',
			],
			host: 'localhost',
			port: 3000,
			proxy: 'https://arkde.local',
			logPrefix: 'webpack',
			logLevel: 'debug',
			ghostMode: false,
		} ),
	],
} );
