'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();


import browserSync from 'browser-sync';

import stringly from './.gulp/stringly';
import config from './config.gulp';
import basscss from './.gulp/basscss.babel';
import bootstrap from './.gulp/bootstrap.babel';
import modcalc from './.gulp/modcalc.babel';
import modservices from './.gulp/modservices.babel';
import modstarlink from './.gulp/modstarlink.babel';
import modmaps from './.gulp/modmaps.babel';
import templates from './.gulp/templates.babel';

const components = { bootstrap, modcalc, modstarlink, modservices, templates };

export const init = () => {
  for (const c of Object.keys(components))
    for (const task of ['clean', 'css', 'build', 'zip']) {
      gulp.task(components[c].COMPONENT + ':' + task, components[c][task]);
      $.util.log(components[c].COMPONENT + ':' + task, '=', components[c][task]);
    }
};

gulp.task('basscss:build', basscss.build);


gulp.task('bootstrap:clean', bootstrap.clean);
gulp.task('bootstrap:css', bootstrap.css);
gulp.task('bootstrap:build', bootstrap.build);
gulp.task('bootstrap:zip', bootstrap.zip);


gulp.task('modcalc:build', modcalc.build);
gulp.task('modcalc:clean', modcalc.clean);
gulp.task('modcalc:css', modcalc.css);
gulp.task('modcalc:images', modcalc.images);
gulp.task('modcalc:js', modcalc.js);
gulp.task('modcalc:other', modcalc.other);
gulp.task('modcalc:zip', modcalc.zip);

gulp.task('modmaps:build', modmaps.build);
gulp.task('modmaps:clean', modmaps.clean);


gulp.task('modservices:css', modservices.css);
gulp.task('modservices:build', modservices.build);
gulp.task('modservices:other', modservices.other);
gulp.task('modservices:zip', modservices.zip);


gulp.task('modstarlink:clean', modstarlink.clean);
gulp.task('modstarlink:css', modstarlink.css);
gulp.task('modstarlink:build', modstarlink.build);
gulp.task('modstarlink:clean:build', modstarlink.buildClean);
gulp.task('modstarlink:other', modstarlink.other);
gulp.task('modstarlink:zip', modstarlink.zip);

//gulp.task('templates:clean', templates.clean);
gulp.task('templates:css', templates.css);
gulp.task('templates:build', templates.build);
//gulp.task('templates:clean:build', templates.buildClean);
gulp.task('templates:other', templates.other);
gulp.task('templates:zip', templates.zip);


gulp.task('list', (done) => {
  init();
  gulp.start('bootstrap:zip');
  done();
});

gulp.task('serve', (done) => {
  $.util.log(`Starting environment: ${config.env}`);
  browserSync(config.plugin.browserSync);
  const comp = $.util.env.mod || 'templates';

  if ( ! Object.keys(components).includes(comp) ) {
    console.log(`Error: unknown module ${comp}`);
    console.log('Usage:\ngulp serve --mod={modcalc|modservices|modstarlink|templates}');
    return(1);
  }
  $.util.log(`watch for ${comp} events`);

  gulp.watch([config.modules[ comp ].src.css])
    .on('change', () => components[comp].css().pipe(browserSync.reload({stream: true}))
    );
  gulp.watch([config.modules[ comp ].src.js ])
    .on('change', gulp.series(components[comp].js, browserSync.reload));
  gulp.watch([...config.modules[ comp ].src.other])
    .on('change', gulp.series(components[comp].other, browserSync.reload));

  done();
});
