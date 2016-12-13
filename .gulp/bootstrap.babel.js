'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();

import stringly from './stringly';
import config from '../config.gulp';   // src.{css, js, images, other}, dest.{css, js, images, other, zip}, postcss
import del from 'del';

const cfg = config.modules.bootstrap;

const COMPONENT = 'bootstrap';

const css = () =>
        gulp.src(cfg.src.sass)
                            .pipe(config.run.debug ? $.debug({title: 'bootstrap: read: '}) : $.util.noop())
        .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
        .pipe($.sass(cfg.options).on('error', $.sass.logError))
        .pipe(config.run.css.cssnano ? $.cssnano() : $.util.noop())
        .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
        .pipe(gulp.dest(cfg.dest.css))
                            .pipe(config.run.debug ? $.debug({title: 'bootstrap: write: '}) : $.util.noop());


const zip = (done) =>
       gulp.src(cfg.src.zip)
            .pipe($.zip('bootstrap.zip'))
            .pipe(gulp.dest(cfg.dest.zip));


const clean = () =>
        del(cfg.dest.css + '/*')
            .then(paths => console.log('Deleted files and folders:\n', paths.join('\n')));


const build = gulp.series(css);
const buildClean = gulp.series(clean, css);

export default { COMPONENT, build, buildClean, clean, css, zip }