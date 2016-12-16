'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();


let browserSync = require('browser-sync').create();
import config from './config.gulp.js';
import modcalc from './.gulp/modcalc.babel';


const transpile = () =>
  modcalc.css().pipe(browserSync.reload({stream: true}));

gulp.task('default', function () {
  $.util.log(`Starting environment: ${config.env}`);
  browserSync.init(config.plugin.browserSync);
  gulp.watch([config.modules.modcalc.src.other])
      .on('change', gulp.series(modcalc.other, browserSync.reload));
  gulp.watch(config.modules.modcalc.src.js)
      .on('change', gulp.series(modcalc.js, browserSync.reload));
  gulp.watch(config.modules.modcalc.src.css).on('change', transpile);
});
