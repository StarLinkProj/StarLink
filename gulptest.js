'use strict';
const upath = require('upath');
global.APP_ROOT = global.APP_ROOT || upath.resolve(__dirname);

const gulp = require('gulp');
const stringly = require('./.gulp/stringly');
const $ = require('gulp-load-plugins')();
const log = $.util.log;
const c = require('./config.gulp.js');
const browserSync = require('browser-sync').create();
const globby = require('globby');

//import modcalc from './.gulp/modcalc.babel';

function initServer (done) {
      /* SUCCESS */
      /*  $.util.log(initServer.name + ' ' + stringly(c));
          $.util.log('initServer');  */
      /* SUCCESS */
      /*  $.util.log(stringly(c) + '\n' + stringly(c.plugins.browserSync)); */
      /* SUCCESS */
      /*  $.util.log(c.plugins.imagemin);  */
      /*  $.util.log(__dirname, upath.resolve(__dirname+'/.././'));  */
      /* SUCCESS
          c.mainConfig.forEach( (v, k) => {
            log(`${k}: ${stringly(v)}`);
          });   */


  //globby(['*', '!index.php']).then(paths => { console.log(paths); });

  c.mainConfig.delete('modcalc');
  c.mainConfig.forEach( (v, k) => {
    globby(v.src.css).then( path => { log(`${k}.src.css:`); console.log(path); } );
  });

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