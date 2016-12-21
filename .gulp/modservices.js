'use strict';
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const log = $.util.log;
const del = require('del');

const c = require('../config.gulp.js');
const _mod = c.sources.get('modservices');

const zipHelper = require('./helpers').zipHelper;
const logPipeline = require('./helpers').logPipeline;


const css = () => {
  return gulp.src(_mod.src.css)
    .pipe($.newer(_mod.dest.css))
    .pipe($.filenames('modservices:css:source'))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
    .pipe($.postcss(_mod.postcss))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(_mod.dest.css))
    .pipe($.filenames('modservices:css:dest'))
    .on('end', logPipeline('modservices', 'css'));
};


const js = (done) => done();


const images = () => {
  return gulp.src(_mod.src.images)
  .pipe($.newer(_mod.dest.images))
  .pipe($.filenames('modservices:images:source'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.dest(_mod.dest.images))
  .pipe($.filenames('modservices:images:dest'))
  .on('end', logPipeline('modservices', 'images'));
};

const other = () => {
  return gulp.src(_mod.src.other)
  .pipe($.newer(_mod.dest.other))
  .pipe($.filenames('modservices:other:source'))
  .pipe(gulp.dest(_mod.dest.other))
  .pipe($.filenames('modservices:other:dest'))
  .on('end', logPipeline('modservices', 'other'));
};

const clean = () =>
        del(_mod.src.clean)
        .then( paths => { console.log(paths.join('\n')) } );

const zip = zipHelper('modservices');

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

gulp.task( 'modservices.clean', clean );
gulp.task( 'modservices.zip', zip );
gulp.task( 'modservices.compile', compile );
gulp.task( 'modservices.compile.css', css );
gulp.task( 'modservices.compile.js', js );
gulp.task( 'modservices.compile.images', images );
gulp.task( 'modservices.compile.other', other );
gulp.task( 'modservices.build', build );
gulp.task( 'modservices.clean.build',
    gulp.series( clean, build)
);

exports.modservices = _mod;