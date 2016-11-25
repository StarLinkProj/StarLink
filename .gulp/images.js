'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import paths    from './config.paths';
const $ = plugins();

const DEBUG = true;

export const images = () => {
  const filterSvg = $.filter(['*', '!*.svg', '!*.ico'], {restore: true});
  return gulp.src(paths.images.src)
  .pipe($.if(DEBUG, $.debug({title: 'images:'})))
  .pipe(filterSvg)
  .pipe($.imagemin())
  .pipe(filterSvg.restore)
  .pipe(gulp.dest(paths.images.build));
};

gulp.task('images', images);



