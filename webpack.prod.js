const path = require( 'path' );
const { merge } = require( 'webpack-merge' );
const common = require( './webpack.common.js' );
const CssMinimizerPlugin = require( 'css-minimizer-webpack-plugin' );
const TerserPlugin = require( 'terser-webpack-plugin' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );

module.exports = merge( common, {
	output: {
		filename: '[name].min.js',
		path: path.resolve( __dirname, 'assets' ),
	},
	mode: 'production',
	devtool: 'source-map',
	optimization: {
		minimizer: [
			new CssMinimizerPlugin(),
			new TerserPlugin( { parallel: true, terserOptions: { output: { comments: false } } } ),
		],
	},
	plugins: [
		new MiniCssExtractPlugin( { filename: '[name].min.css' } ),
	],
} );
