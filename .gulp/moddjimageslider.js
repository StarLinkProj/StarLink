'use strict';
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const log = $.util.log;
const del = require('del');

const c = require('../config.gulp.js');
const _mod = c.sources.get('moddjimageslider');

const zipHelper = require('./helpers').zipHelper;
const logPipeline = require('./helpers').logPipeline;


const css = (done) => done();


const js = (done) => done();


const images = (done) => done();


const markup = () => {
  return gulp.src(_mod.src.markup)
  .pipe($.newer(_mod.dest.markup))
  .pipe($.filenames('moddjimageslider:markup:source'))
  .pipe(gulp.dest(_mod.dest.markup))
  .pipe($.filenames('moddjimageslider:markup:dest'))
  .on('end', logPipeline('moddjimageslider', 'markup'));
};

const clean = () =>
        del(_mod.src.clean)
        .then( paths => { console.log(paths.join('\n')) } );

const zip = zipHelper('moddjimageslider');

const compile =
        gulp.series(
                markup
        );

const build =
        gulp.series(
                compile,
                zip
        );

gulp.task( 'moddjimageslider.clean', clean );
gulp.task( 'moddjimageslider.zip', zip );
gulp.task( 'moddjimageslider.compile', compile );
gulp.task( 'moddjimageslider.compile.markup', markup );
gulp.task( 'moddjimageslider.build', build );
gulp.task( 'moddjimageslider.clean.build',
    gulp.series( clean, build)
);

exports.moddjimageslider = _mod;