'use strict';

const gulp = require('gulp');
const stringly = require('./.gulp/stringly');
const $ = require('gulp-load-plugins')();
const c = require('./config.gulp.js');
let browserSync = require('browser-sync').create();
//import modcalc from './.gulp/modcalc.babel';

function initServer (done) {
/* SUCCESS */
/*  $.util.log(initServer.name + ' ' + stringly(c));
    $.util.log('initServer');  */

/* SUCCESS */
/*  $.util.log(stringly(c) + '\n' + stringly(c.plugins.browserSync)); */

/* SUCCESS */
/*  $.util.log(c.plugins.imagemin);  */

  done();
}


/*gulp.task('watch', function () {
  browserSync.init(c.plugin);
$.util.log(stringly(c.plugin));
  // Run tasks when files change.
  gulp.watch( c.modules.modcalc.src.js )
    .on('change', (path, stats) => gulp.series(modcalc.js, browserSync.reload));
  gulp.watch( c.modules.modcalc.src.css )
    .on('change', (path, stats) => modcalc.css().pipe(browserSync.reload({stream: true})));
} );*/

gulp.task('default', gulp.series(initServer));