'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import paths    from './config.paths';
const $ = plugins();

const DEBUG = true;

export const fonts = () =>
    gulp.src(paths.fonts.src)
    .pipe($.if(DEBUG, $.debug()))
    .pipe(gulp.dest(paths.fonts.build));

gulp.task('fonts', fonts);



