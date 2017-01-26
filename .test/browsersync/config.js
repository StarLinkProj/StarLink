/**
 * Created by mao on 26.01.2017.
 */

/*@ Debugging things */
const
  helpers = require('../../.gulp/helpers'),
  loggy = helpers.loggy;

const
  ContentModule = require('./contentmodule');

let config = {};

config.styleMod = new ContentModule( 'styleMod', {
    srcRoot:  '.src',
    destRoot: '.dist',
  },
  { name: 'styles',
    src:  '.src/style_module/styles/!(_)*.?(p)css',
    dest: '.dist/style_module/css',
    options: {
      watch:      true,
      watchFiles: '.src/style_module/styles/*.?(p)css'
    }
  },
  { name: 'scripts',
    src:  '.src/style_module/scripts/**/*.js',
    dest: '.dist/style_module/js',
    options: {
      watch:      true,
      watchFiles: '.src/style_module/scripts/**/*.js'
    }
  },
  { name: 'markup',
    src:  '.src/style_module/**/*.{html,htm,php,xml}',
    dest: '.dist/style_module/',
    options: {
      watch:      true,
      watchFiles: '.src/style_module/**/*.{html,htm,php,xml}'
    }
  }
);


config.rootMod = new ContentModule( 'rootMod', {
    srcRoot:  '.src',
    destRoot: '.dist'
  },
  { name: 'styles',
    src:  '.src/styles/*.css',
    dest: '.dist/css',
    options: {
      watch:      true,
      watchFiles: '.src/styles/*.css'
    }
  },
  { name: 'markup',
    src:  [ '.src/**/*.{html,php,xml}',
            '!.src/style_module/**/*', '!.src/style_module/**/*.*' ],
    dest: '.dist',
    options: {
      watch:      true,
      watchFiles: [ '.src/**/*.{html,php,xml}',
        '!.src/style_module/**/*', '!.src/style_module/**/*.*' ]
    }
  }
);


module.exports = config;

