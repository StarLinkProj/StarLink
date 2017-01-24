'use strict';
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const log = $.util.log;
const del = require('del');

const c = require('../config.gulp.js');
const _basscss = c.sources.get('basscss');
const _bootstrap = c.sources.get('bootstrap');

const zipHelper = require('./helpers').zipHelper;
const logPipeline = require('./helpers').logPipeline;
const stringly = require('./helpers').stringly;



const basscssCompile = () => {
  return gulp.src(_basscss.src.css)
    .pipe($.newer(_basscss.dest.css))

    .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
    .pipe($.filenames('basscss:compile:source'))

    .pipe($.postcss(_basscss.postcss))

    .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(_basscss.dest.css))
    .pipe($.filenames('basscss:compile:dest'))

    .on('end', logPipeline('basscss', 'compile'));
};

const bootstrapCss = () => {
  return gulp.src(_bootstrap.src.sass)
    .pipe($.newer(_bootstrap.dest.css))

    .pipe($.filenames('bootstrap:css:source'))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))

    .pipe($.sass(_bootstrap.options).on('error', $.sass.logError))
    .pipe($.postcss(_bootstrap.postcss))

    .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(_bootstrap.dest.css))
    .pipe($.filenames('bootstrap:css:dest'))

    .on('end', logPipeline('bootstrap', 'css'));
};

const bootstrapJs = () => {
  return gulp.src(_bootstrap.src.js)
/*  .pipe($.newer(_bootstrap.dest.js))*/

  .pipe($.filenames('bootstrap:js:source'))

  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe(gulp.dest(_bootstrap.dest.js))
  .pipe($.rename('bootstrap.min.js'))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))

  .pipe(gulp.dest(_bootstrap.dest.js))
  .pipe($.filenames('bootstrap:js:dest'))

  .on('end', logPipeline('bootstrap', 'js'));
};

const basscssClean = () =>
        del(_basscss.src.clean)
        .then( paths => { console.log(paths.join('\n')) } );

const bootstrapClean = () =>
        del(_bootstrap.src.clean)
        .then( paths => { console.log(paths.join('\n')) } );


gulp.task( 'basscss.clean', basscssClean );
gulp.task( 'basscss.compile', basscssCompile );
gulp.task( 'basscss.build', basscssCompile );
gulp.task( 'basscss.clean.build',
        gulp.series( basscssClean, basscssCompile )
);


gulp.task( 'bootstrap.clean', bootstrapClean );
gulp.task( 'bootstrap.compile',
        gulp.series( bootstrapCss, bootstrapJs )
);
gulp.task( 'bootstrap.build',
        gulp.series( bootstrapCss, bootstrapJs )
);
gulp.task( 'bootstrap.clean.build',
        gulp.series( bootstrapClean, 'bootstrap.build' )
);


gulp.task( 'vendors.compile',
        gulp.parallel('basscss.compile', 'bootstrap.compile'));
gulp.task( 'vendors.build',
        gulp.parallel('basscss.build', 'bootstrap.build'));
gulp.task( 'vendors.clean',
        gulp.parallel('basscss.clean', 'bootstrap.clean'));


exports.basscss = _basscss;
exports.bootstrap = _bootstrap;