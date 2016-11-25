
var postcss = require('postcss')

module.exports = {
  use: [
    'postcss-cssnext' /*,
    'postcss-custom-media',
    'postcss-custom-properties',
    'postcss-calc',
    'postcss-color-function',
    'postcss-discard-comments',
    'autoprefixer' */
  ],
  input: 'src/*.css',
  dir: 'css'
}


