'use strict';
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const log = $.util.log;
const del = require('del');

const c = require('../config.gulp.js');
const _mod = c.sources.get('modcalc');

const zipHelper = require('./helpers').zipHelper;
const logPipeline = require('./helpers').logPipeline;
const stringly = require('./helpers').stringly;



const css = () => {
  return gulp.src(_mod.src.css)
    .pipe($.newer(_mod.dest.css))
    .pipe($.filenames('modcalc:css:source'))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
    .pipe($.postcss(_mod.postcss))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(_mod.dest.css))
    .pipe($.filenames('modcalc:css:dest'))
    .on('end', logPipeline('modcalc', 'css'));
};


const js = () => {
  return gulp.src(_mod.src.js)
  .pipe($.newer(_mod.dest.js))
  .pipe($.filenames('modcalc:js:source'))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(_mod.dest.js))
  .pipe($.filenames('modcalc:js:dest'))
  .on('end', logPipeline('modcalc', 'js'));
};


const images = () => {
  return gulp.src(_mod.src.images)
  .pipe($.newer(_mod.dest.images))
  .pipe($.filenames('modcalc:images:source'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.dest(_mod.dest.images))
  .pipe($.filenames('modcalc:images:dest'))
  .on('end', logPipeline('modcalc', 'images'));
};

const other = () => {
  return gulp.src(_mod.src.other)
  .pipe($.newer(_mod.dest.other))
  .pipe($.filenames('modcalc:other:source'))
  .pipe(gulp.dest(_mod.dest.other))
  .pipe($.filenames('modcalc:other:dest'))
  .on('end', logPipeline('modcalc', 'other'));
};

const clean = () =>
        del(_mod.src.clean)
        .then( paths => { console.log(paths.join('\n')) } );

const zip = zipHelper('modcalc');

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

gulp.task( 'modcalc.clean', clean );
gulp.task( 'modcalc.compile', compile );
gulp.task( 'modcalc.compile.css', css );
gulp.task( 'modcalc.compile.js', js );
gulp.task( 'modcalc.compile.images', images );
gulp.task( 'modcalc.compile.other', other );
gulp.task( 'modcalc.build', build );
gulp.task( 'modcalc.clean.build',
        gulp.series( clean, build)
);
gulp.task( 'modcalc.zip', zip );


exports.modcalc = _mod;