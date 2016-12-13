'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import paths    from '../paths';
const $ = plugins();

gulp.task('images', () =>
  gulp.src(paths.src)
     .pipe($.print())
     .pipe(gulp.dest(paths.dest))
);



