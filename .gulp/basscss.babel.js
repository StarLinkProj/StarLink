'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();


import config from '../config.gulp';   // src.{css, js, images, other}, dest.{css, js, images, other, zip}, postcss

const css = () =>
        gulp.src(config.modules.basscss.src.css)
            .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
            .pipe($.postcss(config.modules.basscss.postcss))
            .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
            .pipe(config.run.debug ? $.debug({title: 'basscss: read: '}) : $.util.noop())
            .pipe(gulp.dest(config.modules.basscss.dest.css))
            .pipe(config.run.debug ? $.debug({title: 'basscss: write: '}) : $.util.noop());


const zip = () =>
        gulp.src(config.modules.basscss.src.zip)
            .pipe(config.run.debug ? $.debug({title: 'basscss: read: '}) : $.util.noop())
            .pipe($.zip('basscss.zip'))
            .pipe(gulp.dest(config.modules.basscss.dest.zip))
            .pipe(config.run.debug ? $.debug({title: 'basscss: write: '}) : $.util.noop());


const build = gulp.series(css, zip);
export default { build, css, zip }



