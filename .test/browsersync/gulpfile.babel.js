/**
 * Created by mao on 26.01.2017.
 */


/*  The Gulp Almighty */
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();


/*  Debugging things
 *  @TODO delete debug code      */
const filenames = $.filenames;
const util = require('util');
const getLogger = require('glogg');
const logger = getLogger('my-namespace');
const helpers = require('../../.gulp/helpers');
const loggy = helpers.loggy;
const stringly = helpers.stringly;
const logPipeline = helpers.logPipeline;

/* Workflow things */
const _merge = require('lodash.merge');
const del = require('del');
const browserSync = require('browser-sync').create();
const bsReload = browserSync.reload;
const getTask = require('./gettask');


/* Fetch and prepare configuration */
const cfg = require('./config');

_merge(cfg, {
  browserSync: {
    server:  {
      baseDir: '.dist'
    },
    files:   ['.dist/**/*.css'],
    browser: 'chrome',
    notify:  false
  },
  postcssConfig: [
    require('postcss-import'),
    require('postcss-nesting'),
    require('postcss-custom-properties')
  ]
});
_merge(cfg, {
  styleMod: {
    styles: {
      options: {
        reload: bsReload,
        postcss: cfg.postcssConfig
      }
    },
    scripts: {
      options: {
        reload: bsReload
      }
    },
    markup: {
      options: {
        reload: bsReload
      }
    }
  },
  rootMod: {
    styles: {
      options: {
        reload: bsReload,
        postcss: cfg.postcssConfig
      }
    },
    markup: {
      options: {
        reload: bsReload
      }
    }
  }
});

const
  styleMod = cfg.styleMod,
  rootMod = cfg.rootMod;


/* Main Workflow tasks */

gulp.task('styles',
  gulp.parallel(
    getTask( '__styles', styleMod.styles ),
    getTask( '__styles', rootMod.styles )
));


gulp.task('scripts',
  gulp.series(
    getTask( '__scripts', styleMod.scripts )
  )
);


gulp.task('markup',
  gulp.series(
    getTask( '__markup', styleMod.markup ),
    getTask( '__markup', rootMod.markup ),
));


gulp.task('compile',
  gulp.parallel(
    'styles' ,
    'scripts',
    'markup'
));


gulp.task('clean', () => del([ rootMod.destRoot+'/**', '!'+rootMod.destRoot+'/' ]));


gulp.task('build',
  gulp.series(
    'clean',
    'compile'
));


gulp.task('default',
  gulp.series(
    'build',
    serve
));


function serve() {
  browserSync.init(cfg.browserSync);
//  watch();
}


/*
function watch() {
  stylemoduleWatch();
  rootmoduleWatch();
}

function stylemoduleWatch() {
  return gulp.watch( style_module.styles.srcAll, gulp.series('stylemodule:styles:compile')  );
}

function rootmoduleWatch() {
  let rootW = gulp.watch( root_module.markup.src, gulp.parallel( 'rootmodule:markup:compile' ) );
  rootW.on( 'change', (path, stats) => bsReload );
  return rootW;
}*/
