'use strict';

import gulp from 'gulp';
const $ = require('gulp-load-plugins')();
const browserSync = require('browser-sync').create();
const reload = browserSync.reload();

import stringly from './.gulp/stringly';
import config from './config.gulp.js';
import basscss from './.gulp/basscss.babel';
import bootstrap from './.gulp/bootstrap.babel';
import modcalc from './.gulp/modcalc.babel';
import modservices from './.gulp/modservices.babel';
import modstarlink from './.gulp/modstarlink.babel';
import modmaps from './.gulp/modmaps.babel';
import templates from './.gulp/templates.babel';

const components = [ modstarlink, modcalc, modservices, templates ];

export const initialize = () => {
  for (const c of components)
    for (const task of ['clean', 'css', 'build', 'zip']) {
      gulp.task(c.COMPONENT + ':' + task, c[task]);
      $.util.log(c.COMPONENT + ':' + task, '=', c[task]);
    }
}


const doNothing = done => { done(); };

gulp.task('basscss:build', basscss.build);


gulp.task('bootstrap:clean', bootstrap.clean);
gulp.task('bootstrap:css', bootstrap.css);
gulp.task('bootstrap:build', bootstrap.build);
gulp.task('bootstrap:zip', bootstrap.zip);
gulp.task('bootstrap:js', doNothing);


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
gulp.task('modservices:js', doNothing);


gulp.task('modstarlink:clean', modstarlink.clean);
gulp.task('modstarlink:css', modstarlink.css);
gulp.task('modstarlink:js', modstarlink.js);
gulp.task('modstarlink:build', modstarlink.build);
gulp.task('modstarlink:clean:build', modstarlink.buildClean);
gulp.task('modstarlink:other', modstarlink.other);
gulp.task('modstarlink:zip', modstarlink.zip);

//gulp.task('templates:clean', templates.clean);
gulp.task('templates:css', templates.css);
gulp.task('templates:js', templates.js);
gulp.task('templates:build', templates.build);
//gulp.task('templates:clean:build', templates.buildClean);
gulp.task('templates:other', templates.other);
gulp.task('templates:zip', templates.zip);



gulp.task('serve', (done) => {
  $.util.log(`Starting environment: ${config.env}`);
  browserSync(config.plugin.browserSync);

  // checking which component user asks to run using --mod=component_name command line option;
  // if no component specified -> serve all modules & templates
  const comp = $.util.env.mod ? $.util.env.mod : 'all';

/*  if (comp !== 'all') {
    if (!Object.keys(components).includes(comp)) {
      console.log(`Error: unknown module ${comp}`);
      console.log('Usage:\ngulp serve --mod={modcalc|modservices|modstarlink|templates}');
      return (1);
    }
    $.util.log(`watch for ${comp} events`);
    $.util.log(`skip this part for now.`);
    return (0);
  }*/

/*  const js = components.reduce( (acc, cur) => [...acc, ...cur['src']['js']], [] );
  const styles = components.reduce( (acc, cur) => [...acc, ...cur.src.css], [] );
  const other = components.reduce( (acc, cur) => [...acc, ...cur.src.other], [] );
  $.util.log(`css: ${stringly(styles)}\
js: ${stringly(js)}\
other:${stringly(other)}`);*/
  $.util.log(stringly(Object.keys(components[0])));
  //$.util.log(stringly(config));

  for ( const c of components ) {
    $.util.log(c.COMPONENT, stringly(config.modules[ c.COMPONENT ]));
    gulp.watch([ ...config.modules[ c.COMPONENT ].src.js ])
      .on( 'change', gulp.series(c['js'], browserSync.reload) );
    gulp.watch([ ...config.modules[ c.COMPONENT ].src.other ])
      .on( 'change', gulp.series(c.COMPONENT+':other', browserSync.reload) );
    gulp.watch([ ...config.modules[ c.COMPONENT ].src.css ])
      .on( 'change', c['css']().pipe(browserSync.reload({stream: true})) );
  }

  //done();
});

/*gulp.task('modcalc:other:serve', gulp.series(modcalc.other, reload));*/

/*export */const all_serve = () => {

  $.util.log(stringly(config['plugin']));
  browserSync.init(config.plugin.browserSync);

  gulp.watch(config.modules.modcalc.src.js).on('change', (path, stats) => gulp.series(modcalc.js, reload));
  gulp.watch(config.modules.modcalc.src.other).on('change', modcalc.other);
  gulp.watch(config.modules.modcalc.src.css).on('change', (path, stats) => reload);
};
