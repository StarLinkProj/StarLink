'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import paths    from './config.paths';
const $ = plugins();

const DEBUG = true;

export const buildOther = () =>
    gulp.src(paths.other.src)
    .pipe($.if(DEBUG, $.debug({title: 'other:'})))
    .pipe(gulp.dest(paths.other.build));

gulp.task('other', buildOther);



