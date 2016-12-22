'use strict';
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const log = $.util.log;
const del = require('del');

const c = require('../config.gulp.js');
const _mod = c.sources.get('modstarlink');

const zipHelper = require('./helpers').zipHelper;
const logPipeline = require('./helpers').logPipeline;
const stringly = require('./helpers').stringly;



const css = () => {
  return gulp.src(_mod.src.css)
    .pipe($.newer(_mod.dest.css))
    .pipe($.filenames('modstarlink:css:source'))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
    .pipe($.postcss(_mod.postcss))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(_mod.dest.css))
    .pipe($.filenames('modstarlink:css:dest'))
    .on('end', logPipeline('modstarlink', 'css'));
};


const vendorCss = () => {
  return gulp.src(_mod.src.vendorCss)
    .pipe($.newer(_mod.dest.vendorCss))
    .pipe($.filenames('modstarlink:vendorCSS:source'))
    .pipe(gulp.dest(_mod.dest.vendorCss))
    .pipe($.filenames('mmodstarlink:vendorCSS:dest'))
    .on('end', logPipeline('modstarlink', 'vendorCSS'));
};


const js = () => {
  return gulp.src(_mod.src.js)
    .pipe($.newer(_mod.dest.js))
    .pipe($.filenames('modstarlink:js:source'))
    .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
    .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
    .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(_mod.dest.js))
    .pipe($.filenames('modstarlink:js:dest'))
    .on('end', logPipeline('modstarlink', 'js'));
};


const images = () => {
  return gulp.src(_mod.src.images)
    .pipe($.newer(_mod.dest.images))
    .pipe($.filenames('modstarlink:images:source'))
    .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
    .pipe(gulp.src(_mod.src.fonts, {passthrough: true}))
    .pipe($.filenames('modstarlink:images:source'))
    .pipe(gulp.dest(_mod.dest.images))
    .pipe($.filenames('modstarlink:images:dest'))
    .on('end', logPipeline('modstarlink', 'images'));
};

const other = () => {
  return gulp.src(_mod.src.other)
  .pipe($.newer(_mod.dest.other))
  .pipe($.filenames('modstarlink:other:source'))
  .pipe(gulp.dest(_mod.dest.other))
  .pipe($.filenames('modstarlink:other:dest'))
  .on('end', logPipeline('modstarlink', 'other'));
};

const clean = () =>
        del(_mod.src.clean)
        .then( paths => { console.log(paths.join('\n')) } );

const zip = zipHelper('modstarlink');

const compile =
        gulp.parallel(
                css,
                vendorCss,
                js,
                images,
                other
        );

const build =
        gulp.series(
                compile,
                zip
        );

gulp.task( 'modstarlink.clean', clean );
gulp.task( 'modstarlink.zip', zip );
gulp.task( 'modstarlink.compile', compile );
gulp.task( 'modstarlink.compile.css', css );
gulp.task( 'modstarlink.compile.js', js );
gulp.task( 'modstarlink.compile.images', images );
gulp.task( 'modstarlink.compile.other', other );
gulp.task( 'modstarlink.build', build );
gulp.task( 'modstarlink.clean.build',
    gulp.series( clean, build)
);

exports.modstarlink = _mod;