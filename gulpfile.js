'use strict';

const upath = require('upath');
/*  APP_ROOT keeps absolute path to the directory of gulptest.js
 *  i.e. root dir of the package
 */
global.APP_ROOT = global.APP_ROOT || upath.resolve(__dirname);

//<editor-fold desc="Gulp & plugins">

const gulp = require('gulp');
const $ = require('gulp-load-plugins')();

const log = $.util.log;
var HubRegistry = require('gulp-hub');
var hub = new HubRegistry([
        './.gulp/modcalc.js',
        './.gulp/modservices.js',
        './.gulp/modmap.js',
        './.gulp/vendors.js'
]);

//</editor-fold>


const browserSync = require('browser-sync').create();
const reload = browserSync.reload;
const del = require('del');


const c = require('./config.gulp.js');
const modcalc = require('./.gulp/modcalc').modcalc;
const modservices = require('./.gulp/modservices').modservices;
const modmap = require('./.gulp/modmap').modmap;
const basscss = require('./.gulp/vendors').basscss;
const bootstrap = require('./.gulp/vendors').bootstrap;


const zipHelper = require('./.gulp/helpers').zipHelper;
const logPipeline = require('./.gulp/helpers').logPipeline;
const stringly = require('./.gulp/helpers').stringly;




gulp.task('default', (done) => {
  //log(stringly(modcalc));
  //log(stringly(modservices));
  log(stringly(modmap));
  done();
});

