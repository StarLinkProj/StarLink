/*
 list of cssnext plugins in order of application:
 • postcss-custom-properties
 • postcss-apply
 • postcss-calc
 • postcss-nesting
 • postcss-custom-media
 • postcss-media-minmax
 • postcss-custom-selectors
 • postcss-attribute-case-insensitive
 • postcss-color-rebeccapurple
 • postcss-color-hwb
 • postcss-color-gray
 • postcss-color-hex-alpha
 • postcss-color-function
 • postcss-font-variant
 • pleeease-filters
 • postcss-initial
 • pixrem
 • postcss-selector-matches
 • postcss-selector-not
 • postcss-pseudo-class-any-link
 • postcss-replace-overflow-wrap
 • autoprefixer
 • postcss-warn-for-duplicates
 */
module.exports = {
  use: [
    'postcss-import', 'postcss-mixins',
        'postcss-custom-properties', 'postcss-apply', 'postcss-calc', 'postcss-nesting', 'postcss-custom-media',
        'postcss-media-minmax', 'postcss-custom-selectors','postcss-color-hwb','postcss-color-gray',
        'postcss-color-hex-alpha','postcss-color-function', 'pixrem',
    'postcss-url', 'postcss-for', 'postcss-discard-comments',
    'postcss-basscss',
    'autoprefixer',
    //,'cssnano'
  ],
  'postcss-url': {
    url: "rebase",
    basePath: "../../.src/mod_starlink/media/css"
  },
  'autoprefixer': {
    'browsers': '> 1%'
  },
  input: [
    '../../.src/mod_starlink/media/css/styles.css'
  ],
  dir: 'css'
}

