'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();

import config from '../config.gulp';   // src.{css, js, images, other}, dest.{css, js, images, other, zip}, postcss
import merge from 'merge';



const COMPONENT = 'templates';

const css = () =>
        gulp.src(config.modules.templates.src.css)
            .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
            .pipe($.postcss(config.modules.templates.postcss))
            .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
            .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
            .pipe(gulp.dest(config.modules.templates.dest.css))
            .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());


const js = () =>
        gulp.src(config.modules.templates.src.js)
            .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
            .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
            .pipe(config.run.js.uglify ? $.uglify(config.plugin.js.uglify) : $.util.noop())
            .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
            .pipe(gulp.dest(config.modules.templates.dest.js))
            .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());


const images = () =>
        gulp.src(config.modules.templates.src.images)
            .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
            .pipe(config.run.imagemin ? $.imagemin(config.plugin.imagemin) : $.util.noop())
            .pipe(gulp.dest(config.modules.templates.dest.images))
            .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());


const other1 = () =>
        gulp.src(config.modules.templates.src.other)
                .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
        .pipe(gulp.dest(config.modules.templates.dest.other))
                .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());

const other2 = () =>
        gulp.src(config.modules.templates.src.jsBootstrap)
                .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
        .pipe(gulp.dest(config.modules.templates.dest.jsBootstrap))
                .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());

const other = gulp.series(other1, other2);

const zip = () =>
        gulp.src(config.modules.templates.src.zip)
            .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
            .pipe($.zip('starlink.zip'))
            .pipe(gulp.dest(config.modules.templates.dest.zip))
            .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());


const build = gulp.series(gulp.parallel(css, js, images, other), zip);
export default { COMPONENT, build, css, images, js, other, zip }


