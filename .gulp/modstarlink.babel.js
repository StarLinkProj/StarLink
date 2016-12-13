'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();

import del from 'del';

import config from '../config.gulp';   // src.{css, js, images, other}, dest.{css, js, images, other, zip}, postcss



const COMPONENT = 'modstarlink';

const css = () =>
    gulp.src(config.modules.modstarlink.src.css)
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: read: '}) : $.util.noop())
    .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
    .pipe($.postcss(config.modules.modstarlink.postcss))
    .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
    .pipe(gulp.dest(config.modules.modstarlink.dest.css))
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: write: '}) : $.util.noop());


const js = () =>
    gulp.src(config.modules.modstarlink.src.js)
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: read: '}) : $.util.noop())
    .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
    .pipe(config.run.js.uglify ? $.uglify(config.plugin.js.uglify) : $.util.noop())
    .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
    .pipe(gulp.dest(config.modules.modstarlink.dest.js))
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: write: '}) : $.util.noop());


const images = () =>
    gulp.src(config.modules.modstarlink.src.images)
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: read: '}) : $.util.noop())
    .pipe(config.run.imagemin ? $.imagemin(config.plugin.imagemin) : $.util.noop())
    .pipe(gulp.dest(config.modules.modstarlink.dest.images))
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: write: '}) : $.util.noop());


const vendor_css = () =>
    gulp.src(config.modules.modstarlink.src.vendorCss)
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: read: '}) : $.util.noop())
    .pipe(gulp.dest(config.modules.modstarlink.dest.css))
       .pipe(config.run.debug ? $.debug({title: 'modstarlink: write: '}) : $.util.noop());


const other_internal = () =>
    gulp.src(config.modules.modstarlink.src.other)
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: read: '}) : $.util.noop())
    .pipe(gulp.dest(config.modules.modstarlink.dest.other))
        .pipe(config.run.debug ? $.debug({title: 'modstarlink: write: '}) : $.util.noop());



const zip = () =>
        gulp.src(config.modules.modstarlink.src.zip)
            .pipe(config.run.debug ? $.debug({title: 'modstarlink: read: '}) : $.util.noop())
        .pipe($.zip('modstarlink.zip'))
        .pipe(gulp.dest(config.modules.modstarlink.dest.zip))
            .pipe(config.run.debug ? $.debug({title: 'modstarlink: write: '}) : $.util.noop());

const cssClean = () =>
        del([config.modules.modstarlink.dest.css + '/*.*'])
        .then(paths=>console.log(`Deleted: ${paths.join('\n')}`));

const clean = () =>
        del([
          config.modules.modstarlink.dest.css + '/*',
          config.modules.modstarlink.dest.js + '/*',
          config.modules.modstarlink.dest.images + '/*',
          config.modules.modstarlink.dest.other + '/*'
        ]).then(paths => console.log('Deleted files and folders:\n', paths.join('\n')));

const other = gulp.series(vendor_css, other_internal);

const build = gulp.series(gulp.parallel(css, js, images, other), zip);

export default { COMPONENT, build, clean, css, cssClean, images, js, other, zip }


