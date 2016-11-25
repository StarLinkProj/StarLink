'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import paths    from './config.paths';
const $ = plugins();

const DEBUG = true;

export const javascript = () =>
  gulp.src(paths.js.src)
  .pipe($.if(DEBUG, $.debug()))
  .pipe($.uglify())
  .pipe(gulp.dest(paths.js.build));

gulp.task('javascript', javascript);
