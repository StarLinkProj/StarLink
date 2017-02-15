/**
 * Created by mao on 26.01.2017.
 */

/*@ Debugging things */
const
  loggy = require('../../.gulp/helpers').loggy;


/* Prepare configuration */
const
  ContentModule = require('../../.gulp/contentmodule');

let config = {

  tasks: {
    styles: {
      src: [
        '',
        ''
      ],
      dest: '',
      options: {

      }
    },
    scripts: {},
    markup: {},
    zip: {}
  },




  options: {

    browserSync: {
      server:  {
        baseDir: '.test'
      },
      files:   ['.test/**/*.{css,html}'],
      browser: 'chrome',
      notify:  false
    }

/*  ,postcssConfig: [
      require('postcss-import'),
      require('postcss-nesting'),
      require('postcss-custom-properties')
    ]*/

  }

};

config.bootstrap = new ContentModule( 'bootstrap', {
    srcRoot:  '.src/vendor/bootstrap',
    destRoot: '.buid/vendor',
  },
  { name:   'styles',
    src:    '.src/vendor/bootstrap/bootstrap.scss',
    dest:   '.buid/vendor/css',
    options: {
      watch: false
  }},
  { name:   'scripts',
    src:    '.src/vendor/bootstrap/js/bootstrap.js',
    dest:   '.buid/vendor/js',
    options: {
      watch: false
}});

config.basscss = new ContentModule( 'basscss', {
    srcRoot:  '.src/vendor/basscss',
    destRoot: '.buid/vendor',
  },
  { name:   'styles',
    src:    '.src/vendor/basscss/src/base.css',
    dest:   '.buid/vendor/css',
    options: {
      watch: false
    }}
);


module.exports = config;

