'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();


import stringly from './stringly';
import config from '../config.gulp';   // src.{css, js, images, other}, dest.{css, js, images, other, zip}, postcss


const css = () =>
        gulp.src(config.modules.modservices.src.css)
            .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
            .pipe($.postcss(config.modules.modservices.postcss))
            .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
            .pipe(config.run.debug ? $.debug({title: 'modservices: read: '}) : $.util.noop())
            .pipe(gulp.dest(config.modules.modservices.dest.css))
            .pipe(config.run.debug ? $.debug({title: 'modservices: write: '}) : $.util.noop());


const images = () =>
        gulp.src(config.modules.modservices.src.images)
            .pipe(config.run.debug ? $.debug({title: 'modservices: read: '}) : $.util.noop())
            .pipe(config.run.imagemin ? $.imagemin(config.plugin.imagemin) : $.util.noop())
            .pipe(gulp.dest(config.modules.modservices.dest.images))
            .pipe(config.run.debug ? $.debug({title: 'modservices: write: '}) : $.util.noop());


const other = () =>
        gulp.src(config.modules.modservices.src.other)
            .pipe(config.run.debug ? $.debug({title: 'modservices: read: '}) : $.util.noop())
            .pipe(gulp.dest(config.modules.modservices.dest.other))
            .pipe(config.run.debug ? $.debug({title: 'modservices: write: '}) : $.util.noop());


const zip = () =>
        gulp.src(config.modules.modservices.src.zip)
            .pipe(config.run.debug ? $.debug({title: 'modservices: read: '}) : $.util.noop())
            .pipe($.zip('mod_starlink_services.zip'))
            .pipe(gulp.dest(config.modules.modservices.dest.zip))
            .pipe(config.run.debug ? $.debug({title: 'modservices: write: '}) : $.util.noop());


const build = gulp.series(gulp.parallel(css, images, other), zip);
export default { build, css, images, other, zip }


