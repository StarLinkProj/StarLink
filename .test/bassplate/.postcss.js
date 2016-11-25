/*
  require('postcss-import')(),
  require('postcss-use')(),
  require('postcss-sass-extend')(),
  require('postcss-mixins')(),
  require('postcss-for')(),
  require('postcss-simple-vars')(),
  require('postcss-nested')(),
  require('postcss-utilities')(),
  require('precss')(),
  require('postcss-color-function')(),
  require('postcss-color-gray')(),
 // require('postcss-cssnext')({ browsers: ['> 1%'] }),
 // require('postcss-bem')({style: 'suit'}),
  require('css-mqpacker')({sort: true})

  */

module.exports = function (postcss) {
  return postcss([ 
    require('postcss-import')
   ,require('postcss-cssnext') 
   ,require('postcss-use')({ modules: ['postcss-custom-properties', 'autoprefixer', 'cssnano', 'cssnext'] })     
  //  ,require('postcss-custom-media')
  //  ,require('postcss-custom-properties')
  //  ,require('postcss-calc')
  //  ,require('postcss-color-function')
  //  ,require('postcss-discard-comments')
  //  ,require('autoprefixer')
]
)};