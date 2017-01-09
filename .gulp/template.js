'use strict';
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const log = $.util.log;
const del = require('del');

const c = require('../config.gulp.js');
const _mod = c.sources.get('template');

const zipHelper = require('./helpers').zipHelper;
const logPipeline = require('./helpers').logPipeline;
const stringly = require('./helpers').stringly;



const css = () => {
  return gulp.src(_mod.src.css)
    .pipe($.newer(_mod.dest.css))
    .pipe($.filenames('template:css:source'))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
    .pipe($.postcss(_mod.postcss))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(_mod.dest.css))
    .pipe($.filenames('template:css:dest'))
    .on('end', logPipeline('template', 'css'));
};


const js = () => {
  return gulp.src(_mod.src.js)
    .pipe($.newer(_mod.dest.js))
    .pipe($.filenames('template:js:source'))
    .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
    .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
    .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(_mod.dest.js))
    .pipe($.filenames('template:js:dest'))
    .on('end', logPipeline('template', 'js'));
};


const jsBootstrap = () => {
  return gulp.src(_mod.src.js)
  .pipe($.newer(_mod.dest.js))
  .pipe($.filenames('template:jsBootstrap:source'))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(_mod.dest.js))
  .pipe($.filenames('template:jsBootstrap:dest'))
  .on('end', logPipeline('template', 'jsBootstrap'));
};


const images = () => {
  return gulp.src(_mod.src.images)
    .pipe($.newer(_mod.dest.images))
    .pipe($.filenames('template:images:source'))
    .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
    .pipe(gulp.dest(_mod.dest.images))
    .pipe($.filenames('template:images:dest'))
    .on('end', logPipeline('template', 'images'));
};


const markup = () => {
  return gulp.src(_mod.src.markup)
  .pipe($.newer(_mod.dest.markup))
  .pipe($.filenames('template:markup:source'))
  .pipe(gulp.dest(_mod.dest.markup))
  .pipe($.filenames('template:markup:dest'))
  .on('end', logPipeline('template', 'markup'));
};


const other = () => {
  return gulp.src(_mod.src.other)
  .pipe($.newer(_mod.dest.other))
  .pipe($.filenames('template:other:source'))
  .pipe(gulp.dest(_mod.dest.other))
  .pipe($.filenames('template:other:dest'))
  .on('end', logPipeline('template', 'other'));
};

const clean = () =>
        del(_mod.src.clean)
        .then( paths => { console.log(paths.join('\n')) } );

const zip = zipHelper('template');

const compile =
        gulp.parallel(
                css,
                js,
                jsBootstrap,
                images,
                markup,
                other
        );

const build =
        gulp.series(
                compile,
                zip
        );

gulp.task( 'template.clean', clean );
gulp.task( 'template.zip', zip );
gulp.task( 'template.compile', compile );
gulp.task( 'template.compile.css', css );
gulp.task( 'template.compile.js', js );
gulp.task( 'template.compile.images', images );
gulp.task( 'template.compile.other', other );
gulp.task( 'template.build', build );
gulp.task( 'template.clean.build',
    gulp.series( clean, build)
);

exports.template = _mod;