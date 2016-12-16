'use strict';
const upath = require('upath');
global.APP_ROOT = global.APP_ROOT || upath.resolve(__dirname);

//<editor-fold desc="Gulp & helpers">
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const noop = $.util.noop;
const log = $.util.log;
const debug = operation => $.debug({title: operation});
//</editor-fold>

const c = require('./config.gulp.js');
const components = c.sources;
const browserSync = require('browser-sync').create();
const globby = require('globby');
const stringly = require('./.gulp/stringly');



//<editor-fold desc="InitServer consequent successful bits">
/* SUCCESS */
/*  $.util.log(initServer.name + ' ' + stringly(c));
 $.util.log('initServer');  */
/* SUCCESS */
/*  $.util.log(stringly(c) + '\n' + stringly(c.plugins.browserSync)); */
/* SUCCESS */
/*  $.util.log(c.plugins.imagemin);  */
/*  $.util.log(__dirname, upath.resolve(__dirname+'/.././'));  */
/* SUCCESS
 c.sources.forEach( (v, k) => {
 log(`${k}: ${stringly(v)}`);
 });   */
/* SUCCESS
 c.sources.forEach( (v, k) => {
 globby(v.src.css).then( path => { log(`${k}.src.css:`); console.log(path); } );
 });  */

/*  SUCCESS
 c.sources.forEach( (v, k) => {
 return gulp.src(v.src.css).pipe($.debug({title: `${k}: read: `}));
 });  */
//</editor-fold>

function initServer (done) {
  c.sources.delete('modcalc');
  c.sources.forEach( (v, k) => {
    return gulp.src(v.src.css)
      .on('end', () => {
        log('task ' + k + ':css');
        console.log( $.filenames.get(k + ':css').map(upath.normalize) );
        $.filenames.forget(k + ':css');
      })
    .pipe($.filenames(k + ':css'));
  });

  done();
}


function buildVendorsCss() {
  return gulp.src(components.get('vendors').src.css)
    .pipe($.filenames('buildVendorsCss'))
    .pipe(c.run.sourcemaps ? $.sourcemaps.init() : noop())
    .pipe($.postcss(components.get('vendors').postcss))
    .pipe(c.run.sourcemaps ? $.sourcemaps.write('.') : noop())
    .pipe(gulp.dest(components.get('vendors').dest.css))
      .on('end', () => {
        log('buildVendorsCss: ');
        console.log( $.filenames.get('buildVendorsCss').map(upath.normalize) );
        $.filenames.forget('buildVendorsCss');
      });
}


function buildModulesCss() {
  return gulp.src([components.get('modules').src.css, '!**/mod_starlink_{map,services,calculator_outsourcing}/**/*.*'])
  .pipe($.filenames('css'))
  .pipe(c.run.sourcemaps ? $.sourcemaps.init() : noop())
  .pipe($.postcss(components.get('modules').postcss))
          .pipe($.postcss([require('cssnano')(), require('postcss-prettify')]))
  .pipe(c.run.sourcemaps ? $.sourcemaps.write('.') : noop())
  .pipe(gulp.dest(components.get('modules').dest.css))
  .on('end', () => {
    log('buildModulesCss: ');
    console.log( $.filenames.get('css').map(upath.normalize) );
    $.filenames.forget('css');
  });
}


function buildVendorsJs(done) {
  log('vendors: fake buildVendorsJs');
  done();
}

function buildModulesJs(done) {
  log('modules: fake buildModulesJs');
  done();
}


gulp.task('default', initServer);
gulp.task('build:vendors', gulp.parallel(buildVendorsCss, buildVendorsJs));
gulp.task('build:modules', gulp.parallel(buildModulesCss, buildModulesJs));


/*exports.initServer = initServer;*/

/*gulp.task('watch', function () {
  browserSync.init(c.plugin);
$.util.log(stringly(c.plugin));
  // Run tasks when files change.
  gulp.watch( c.modules.modcalc.src.js )
    .on('change', (path, stats) => gulp.series(modcalc.js, browserSync.reload));
  gulp.watch( c.modules.modcalc.src.css )
    .on('change', (path, stats) => modcalc.css().pipe(browserSync.reload({stream: true})));
} );*/

