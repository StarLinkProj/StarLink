'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import requireDir from 'require-dir';
import yargs    from 'yargs';
import rimraf   from 'rimraf';
import path     from 'path';
import {create as bcCreate} from 'browser-sync';
const browser = bcCreate();
import paths from './.gulp/config.paths';
const $ = plugins();
requireDir('./.gulp', { recurse: true } );

// Look for the --production flag
const PRODUCTION = !!(yargs.argv.production);

const cleanBuild = (done) => rimraf("./.build", done);
gulp.task('build:clean', cleanBuild);

gulp.task('build',
  gulp.series(
    'build:clean',
    gulp.parallel(
      'postcss',
      'images',
      'fonts',
      'javascript',
      'other'
    )
  )
);

const DEBUG = false;

const deployModules = () =>
  gulp.src(paths.modules.build)
  .pipe($.rename(function(path) {
    if(DEBUG)
      console.log(`rename ${path.dirname} to ${path.dirname.replace('\\media','')}`);
    else
      path.dirname = path.dirname.replace('\\media','');
  }))
  .pipe($.debug({title: 'deploy modules:'}))
  .pipe($.if(!DEBUG, gulp.dest(paths.modules.deploy)));

const deployTemplates = () =>
  gulp.src(paths.templates.build)
  .pipe($.debug({title: 'deploy templates:'}))
  .pipe($.if(!DEBUG, gulp.dest(paths.templates.deploy)));

gulp.task('build:deploy',
  gulp.parallel(
    deployModules,
    deployTemplates
  )
);

const server = () =>
  browser.init({
    server: {
      baseDir: '.'
    }
  });



