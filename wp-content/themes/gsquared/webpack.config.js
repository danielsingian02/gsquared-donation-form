// webpack.config.js
const path = require('path');

module.exports = {
  // ... other webpack config

  plugins: [
    // ... your plugins
  ],
  watch: true,
  watchOptions: {
    ignored: /node_modules/,
    aggregateTimeout: 300,
    poll: 1000,
  },
  // Define your entry and output files
  entry: './src/index.js',
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'bundle.js',
  },
  // Add other configurations as needed
};
