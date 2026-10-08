const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry: {
    main: './assets/js/main.js',
    editor: './assets/js/editor.js',
  },
  output: {
    path: path.resolve(__dirname, 'public'),
    filename: '[name].js',
    clean: true,
  },
  module: {
    rules: [
      {
        test: /\.s?css$/,
        use: [MiniCssExtractPlugin.loader, 'css-loader', 'postcss-loader', 'sass-loader'],
      },
    ],
  },
  plugins: [new MiniCssExtractPlugin({ filename: '[name].css' })],
  devtool: false,
  stats: 'errors-warnings',
};
