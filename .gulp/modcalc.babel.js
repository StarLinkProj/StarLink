'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();

import stringly from './stringly';
import config from '../config.gulp';   // src.{css, js, images, other}, dest.{css, js, images, other, zip}, postcss
import del from 'del';

const COMPONENT = 'modcalc';

const css = () =>
        gulp.src(config.modules.modcalc.src.css)
                .pipe(config.run.debug ? $.debug({title: 'modcalc: read: '}) : $.util.noop())
        .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
        .pipe($.postcss(config.modules.modcalc.postcss))
        .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
        .pipe(gulp.dest(config.modules.modcalc.dest.css))
                .pipe(config.run.debug ? $.debug({title: 'modcalc: write: '}) : $.util.noop());


const js = () =>
        gulp.src(config.modules.modcalc.src.js)
                .pipe(config.run.debug ? $.debug({title: 'modcalc: read: '}) : $.util.noop())
        .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
        .pipe(config.run.js.uglify ? $.uglify(config.plugin.js.uglify) : $.util.noop())
        .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
        .pipe(gulp.dest(config.modules.modcalc.dest.js))
                .pipe(config.run.debug ? $.debug({title: 'modcalc: write: '}) : $.util.noop());


const images = () =>
        gulp.src(config.modules.modcalc.src.images)
                .pipe(config.run.debug ? $.debug({title: 'modcalc: read: '}) : $.util.noop())
        .pipe(config.run.imagemin ? $.imagemin(config.plugin.imagemin) : $.util.noop())
        .pipe(gulp.dest(config.modules.modcalc.dest.images))
                .pipe(config.run.debug ? $.debug({title: 'modcalc: write: '}) : $.util.noop());


const other = () =>
        gulp.src(config.modules.modcalc.src.other)
                .pipe(config.run.debug ? $.debug({title: 'modcalc: read: '}) : $.util.noop())
        .pipe(gulp.dest(config.modules.modcalc.dest.other))
                .pipe(config.run.debug ? $.debug({title: 'modcalc: write: '}) : $.util.noop());


const zip = () =>
        gulp.src(config.modules.modcalc.src.zip)
        .pipe($.zip('mod_starlink_calculator_outsourcing.zip'))
        .pipe(gulp.dest(config.modules.modcalc.dest.zip));


const clean = () =>
        del([
          config.modules.modcalc.dest.css + '/*',
          config.modules.modcalc.dest.js + '/*',
          config.modules.modcalc.dest.other + '/*'
        ]).then(paths => console.log('Deleted files and folders:\n', paths.join('\n')));


const build = gulp.series(gulp.parallel(css, js, images, other), zip);
const buildClean = gulp.series(clean, build);

export default { COMPONENT, build, buildClean, clean, css, images, js, other, zip }


