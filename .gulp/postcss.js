'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import paths    from './config.paths';
const $ = plugins();

const DEBUG = true;

const postCSSplugins = [
  require('postcss-import')({path: [ ".src/mod_starlink/media/css" ]}), require('postcss-mixins'),
  require('postcss-custom-properties'), require('postcss-apply'), require('postcss-calc'), require('postcss-nesting'), require('postcss-custom-media'),
  require('postcss-media-minmax'), require('postcss-custom-selectors'), require('postcss-color-hwb'), require('postcss-color-gray'),
  require('postcss-color-hex-alpha'),require('postcss-color-function'), require('pixrem'),
  require('postcss-url'), require('postcss-for'), require('postcss-discard-comments'),
  require('autoprefixer')({ 'browsers': '> 1%' }),
  require('css-mqpacker')({sort: true})
];


const pcss_common = () =>
        gulp.src(paths.postcss.mod_starlink.src)
        .pipe($.if(DEBUG, $.debug()))
        .pipe($.postcss(postCSSplugins))
        .pipe(gulp.dest(paths.postcss.mod_starlink.build));

const pcss_vendor = () =>
        gulp.src(paths.postcss.vendor.src)
        .pipe($.if(DEBUG, $.debug()))
        .pipe(gulp.dest(paths.postcss.vendor.build));

const pcss_calc = () =>
        gulp.src(paths.postcss.mod_calc.src)
        .pipe($.if(DEBUG, $.debug()))
        .pipe($.postcss(postCSSplugins))
        .pipe(gulp.dest(paths.postcss.mod_calc.build));

const pcss_services = () =>
        gulp.src(paths.postcss.mod_services.src)
        .pipe($.if(DEBUG, $.debug()))
        .pipe($.postcss(postCSSplugins))
        .pipe(gulp.dest(paths.postcss.mod_services.build));

export const pcss_templates = () =>
        gulp.src(paths.postcss.templates.src)
        .pipe($.if(DEBUG, $.debug()))
        .pipe($.postcss(postCSSplugins))
        .pipe(gulp.dest(paths.postcss.templates.build));

gulp.task('postcss',
  gulp.parallel(
    pcss_common,
    pcss_vendor,
    pcss_calc,
    pcss_services,
    pcss_templates
  )
);

gulp.task('dbg', gulp.series(pcss_services));
