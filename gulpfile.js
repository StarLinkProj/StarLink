'use strict';

const upath = require('upath');
/*  APP_ROOT keeps absolute path to the directory of gulpfile.js
 *  i.e. root dir of the package
 */
global.APP_ROOT = global.APP_ROOT || upath.resolve(__dirname);

//<editor-fold desc="Gulp & plugins">

const gulp = require('gulp');
const $ = require('gulp-load-plugins')();

const log = $.util.log;
let HubRegistry = require('gulp-hub');
// let hub = new HubRegistry([
//         './.gulp/*.js',
//         './.gulp/!helpers.js'
// ]);

//gulp.registry(hub);

//</editor-fold>


const browserSync = require('browser-sync').create();
const reload = browserSync.reload;
const del = require('del');


const c = require('./config.gulp.js');
const modcalc = require('./.gulp/modcalc').modcalc;
const modservices = require('./.gulp/modservices').modservices;
const modmap = require('./.gulp/modmap').modmap;
const modstarlink = require('./.gulp/modstarlink').modstarlink;
const template = require('./.gulp/template').template;
const basscss = require('./.gulp/vendors').basscss;
const bootstrap = require('./.gulp/vendors').bootstrap;


const zipHelper = require('./.gulp/helpers').zipHelper;
const logPipeline = require('./.gulp/helpers').logPipeline;
const stringly = require('./.gulp/helpers').stringly;

// @TODO: watch for changes & recompile tasks in each .gulp/* module
// @TODO: serve function here


gulp.task('default', (done) => {
  done();
});

const clean = gulp.parallel(
        'vendors.clean',
        'modcalc.clean',
        'modmap.clean',
        'modservices.clean',
        'modstarlink.clean',
        'template.clean'
);


gulp.task( 'modstarlink.compile',
        gulp.series( 'vendors.compile', 'modstarlink.compile.noVendors' )
);


const compile = gulp.series(
        'vendors.compile',
        gulp.parallel(
                'modcalc.compile',
                'modmap.compile',
                'modservices.compile',
                'modstarlink.compile',
                'template.compile'
        )
);

const zip = gulp.parallel(
        'modcalc.zip',
        'modmap.zip',
        'modservices.zip',
        'modstarlink.zip',
        'template.zip'
);

// const build = gulp.series ( compile, zip );




//gulp.task( 'clean', clean );
gulp.task( 'compile', compile );
// gulp.task( 'build', build );
// gulp.task( 'clean.build',
//         gulp.series( clean, build)
// );
gulp.task( 'zip', zip );


gulp.task( 'compile.css',
        gulp.series(

        )
);

// HubRegistry([
//   './.gulp/*.js',
//   './.gulp/!helpers.js'
// ]);

gulp.registry(new HubRegistry([
    './.gulp/*.js',
    './.gulp/!helpers.js'
  ])
);
