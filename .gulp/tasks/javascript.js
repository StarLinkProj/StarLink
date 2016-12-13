'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import paths    from '../paths';
const $ = plugins();

gulp.task('javascript', function () {
  return gulp.src(paths.js.src)
    .pipe($.if(!PRODUCTION, $.sourcemaps.init()))
    .pipe($.uglify())
    .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
    .pipe(gulp.dest(paths.js.dest));
});
