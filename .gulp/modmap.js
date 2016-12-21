'use strict';
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const log = $.util.log;
const del = require('del');

const c = require('../config.gulp.js');
const _mod = c.sources.get('modmap');

const zipHelper = require('./helpers').zipHelper;
const logPipeline = require('./helpers').logPipeline;
const stringly = require('./helpers').stringly;



const css = done => done();


const js = done => done();


const images = done => done();


const other = () => {
  return gulp.src(_mod.src.all)
  .pipe($.newer(_mod.dest.all))
  .pipe($.filenames('modmap:all:source'))
  .pipe(gulp.dest(_mod.dest.all))
  .pipe($.filenames('modmap:all:dest'))
  .on('end', logPipeline('modmap', 'all'));
};

const clean = () =>
        del(_mod.src.clean)
        .then( paths => { console.log(paths.join('\n')) } );

const zip = zipHelper('modmap');

const compile =
        gulp.parallel(
                css,
                js,
                images,
                other
        );

const build =
        gulp.series(
                compile,
                zip
        );

gulp.task( 'modmap.clean', clean );
gulp.task( 'modmap.zip', zip );
gulp.task( 'modmap.compile', compile );
gulp.task( 'modmap.compile.css', css );
gulp.task( 'modmap.compile.js', js );
gulp.task( 'modmap.compile.images', images );
gulp.task( 'modmap.compile.other', other );
gulp.task( 'modmap.build', build );
gulp.task( 'modmap.clean.build',
    gulp.series( clean, build)
);

exports.modmap = _mod;