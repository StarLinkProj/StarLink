'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();


import stringly from './stringly';
import config from '../config.gulp';   // src.{css, js, images, other}, dest.{css, js, images, other, zip}, postcss



const all = () =>
        gulp.src(config.modules.modmaps.src.all)
            .pipe(config.run.debug ? $.debug({title: 'modmaps: read: '}) : $.util.noop())
            .pipe(gulp.dest(config.modules.modmaps.dest.all))
            .pipe(config.run.debug ? $.debug({title: 'modmaps: write: '}) : $.util.noop());


const clean = () =>
        del([
          config.modules.modmaps.dest.all + '/*'
        ]).then(paths => console.log('Deleted files and folders:\n', paths.join('\n')));


const zip = () =>
        gulp.src(config.modules.modmaps.src.zip)
            .pipe(config.run.debug ? $.debug({title: 'modmaps: read: '}) : $.util.noop())
            .pipe($.zip('mod_starlink_maps.zip'))
            .pipe(gulp.dest(config.modules.modmaps.dest.zip))
            .pipe(config.run.debug ? $.debug({title: 'modmaps: write: '}) : $.util.noop());


const build = gulp.series(all, zip);
export default { build, all, clean, zip }


