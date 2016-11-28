
module.exports = function (postcss) {
  return postcss([ 
            require('postcss-import'),
            require('postcss-custom-media'),
            require('postcss-custom-properties'),
            require('postcss-calc'),
            require('postcss-color-function')
  //  ,require('postcss-discard-comments')
  //  ,require('autoprefixer')
  // require('postcss-plugin-context')({
  //  for: require('postcss-for'),
  //  discardComments: require('postcss-discard-comments')
  //}),
]
)};
