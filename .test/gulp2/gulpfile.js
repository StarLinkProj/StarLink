/**
 * Created by mao on 02.02.2017.
 */


/*  The Gulp Almighty */
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();


/*  Debugging things
 *  @TODO delete debug code      */
const loggy = require('../../.gulp/helpers').loggy;
const stringly = require('../../.gulp/helpers').stringly;


/* Workflow things */
const production = require('./cfg').production;
const _merge = require('lodash.merge');
const del = require('del');
const browserSync = require('browser-sync').create();
const bsReload = browserSync.reload;


/* Fetch and prepare configuration */

const $includePath = '_src/_includes/';

//const cfg = require('./config');
const cfg = {};

_merge(cfg, {
  browserSync: {
    server:  {
      baseDir: '_build'
    },
    //files:   ['_build/**/*.{css,html}'],
    browser: 'chrome',
    notify:  false
  }
/*  ,
  postcssConfig: [
    require('postcss-import'),
    require('postcss-nesting'),
    require('postcss-custom-properties')
  ]*/
});


const taskCfg = {
  'bootstrap-styles': {
    src:  '_src/vendor/bootstrap-sass/styles/bootstrap.scss',
    dest: '_build/css',
    srcWatch: [
      $includePath + '*.css',
      '_src/vendor/bootstrap-sass/styles/*.scss'
    ],
    sassOptions: {
      includePaths: [
        '_src/_includes',
        'node_modules/bootstrap-sass/assets/stylesheets'
      ]
    },
    watch: !production,
    browserSync: browserSync
  },

  'basscss-styles': {
    src:  '_src/vendor/basscss/base.css',
    dest: '_build/css',
    srcWatch: [
      $includePath + '*.css',
      '_src/vendor/basscss/**/*.css'
    ],
    postcss: [
      require('postcss-import')({
        path: [ $includePath ]
      }),
      require('postcss-custom-media'),
      require('postcss-custom-properties'),
      require('postcss-simple-vars'),
      require('postcss-color-function'),
      require('postcss-calc')({precision: 10}),
      /*    require('postcss-color-function'), */
      require('postcss-discard-comments'),
      require('css-mqpacker')({sort: true}),
      //require('cssnano'),
      require('postcss-prettify')
      /*   ,require('autoprefixer') */
    ],
    watch: !production,
    browserSync: browserSync
  },

  'mod_starlink-styles': {
    src:  '_src/mod_starlink/styles/{styles,print,offline}.pcss',
    dest: '_build/css',
    srcWatch: [
      $includePath + '*.css',
      '_src/mod_starlink/styles/*.{,p}css',
      '_build/css/{bootstrap,base}.css'
    ],
    postcss: [
      require('postcss-import')({
        path: [
          $includePath,
          '_build/css'
        ]
      }),
      require('postcss-mixins'),
      require('postcss-simple-vars'),
      require('postcss-custom-properties'),
      require('postcss-apply'),
      require('postcss-calc')({precision: 10}),
      require('postcss-nesting'),
      require('postcss-custom-media'),
      require('postcss-extend'),
      require('postcss-media-minmax'),
      require('postcss-custom-selectors'),
      require('postcss-color-hwb'),
      require('postcss-color-gray'),
      require('postcss-color-hex-alpha'),
      require('postcss-color-function'),
      require('postcss-for'),
      require('postcss-discard-comments'),
      // require('cssnano'),
      // require('postcss-prettify'),
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ],
    watch: !production,
    browserSync: browserSync
  }

};



/* Task execution engine */

/**
 * Get a task. This function just gets a task from the tasks directory.
 *
 * @param {string} name The name of the task.
 * @returns {function} The task!
 *
 * Task example:
 *
 *   sometask.js:
 *   ------------
 *
 *        module.exports = (gulp, plugins, options) =>
 *          gulp.src(options.src)
 *          .pipe(plugins.if(options.minify, plugins.cssnano()))
 *          .gulp.dest(options.dest)
 *
 *   options = {
 *     src: [ '/some/path', 'some/path2' ],
 *     dest:  '/path3',
 *     ...
 *     other options
 *     ...
 *   };
 *
 */

function getTask(name) {
  //if(name==='mod_starlink-styles') console.dir(taskCfg[name]);
 return require(`./_tasks/${name}`)(gulp, $, taskCfg[name] || {});
}


/* Main Workflow tasks */

gulp.task('bootstrap:clean', () => getTask('bootstrap-clean'));
gulp.task('bootstrap:styles', () => getTask('bootstrap-styles'));

gulp.task('basscss:clean', () => getTask('basscss-clean'));
gulp.task('basscss:styles', () => getTask('basscss-styles'));

gulp.task('mod_starlink:clean', () => getTask('mod_starlink-clean'));
gulp.task('mod_starlink:styles', () => getTask('mod_starlink-styles'));


gulp.task('clean', gulp.parallel('bootstrap:clean', 'basscss:clean', 'mod_starlink:clean'));
gulp.task('styles',
  gulp.series(
    gulp.parallel(
      'bootstrap:styles', 'basscss:styles'
    ),
    gulp.series('mod_starlink:styles')
  )
);


gulp.task('default',
  gulp.series(
    'styles',
    serve
));

gulp.task('build',
  gulp.series(
    'clean',
    'styles',
     serve
  ));


function serve(done) {
  if (production)
    done();
  else {
    browserSync.init(cfg.browserSync);
    gulp.watch(['_build/*.html']).on('change', bsReload);
  }
}


// function watchMarkup() {
//   gulp.watch(['_build/*.html'])
//     .on('change', bsReload);
// }

gulp.task('debug', (done) => { console.log(production); done(); } );