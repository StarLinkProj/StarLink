'use strict';

import gulp from 'gulp';
import stringly from './.gulp/stringly';
const $ = require('gulp-load-plugins')();
import c from './config.gulp.js';
let browserSync = require('browser-sync').create();
import modcalc from './.gulp/modcalc.babel';


gulp.task('watch', function () {
  browserSync.init(c.plugin);
$.util.log(stringly(c.plugin));
  // Run tasks when files change.
  gulp.watch( c.modules.modcalc.src.js )
    .on('change', (path, stats) => gulp.series(modcalc.js, browserSync.reload));
  gulp.watch( c.modules.modcalc.src.css )
    .on('change', (path, stats) => modcalc.css().pipe(browserSync.reload({stream: true})));
/*  gulp.watch( paths.sass, [ 'styles' ] );
  gulp.watch( paths.scripts, [ 'scripts' ] );*/
/*  gulp.watch( paths.concat_scripts, [ 'scripts' ] );
  gulp.watch( paths.sprites, [ 'sprites' ] );
  gulp.watch( paths.php, [ 'markup' ] );*/
} );
