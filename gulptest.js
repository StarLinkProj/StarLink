'use strict';
const upath = require('upath');
global.APP_ROOT = global.APP_ROOT || upath.resolve(__dirname);

//<editor-fold desc="Gulp & helpers">
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const noop = $.util.noop;
const log = $.util.log;
const debug = operation => $.debug({title: operation});
//</editor-fold>

const c = require('./config.gulp.js');
const components = c.sources;
const browserSync = require('browser-sync').create();
const globby = require('globby');
const merge2 = require('merge2');
const stringly = require('./.gulp/stringly');



//<editor-fold desc="InitServer consequent successful bits">

//</editor-fold>

function initServer (target = 'css') {
  return function() {
    let s = merge2();
    c.sources.forEach((v, k) => {
      log(k+': '+target);
      s.add(gulp.src(v.src[target], {read: false})
        .pipe($.filenames('initserver' + k))
        .on('end', () => {
          console.log(`task ${k}:${target}`);
          console.log(
            $.filenames.get('initserver' + k)
            .reduce((s1, s2) => `${s1}    ${upath.normalize(s2)}\n`, '')
          );
        })
      );
    });
    return s;
  }
}


function buildVendorsCss() {
  return gulp.src(components.get('vendors').src.css)
    .pipe($.filenames('css-v'))
    .pipe(c.run.sourcemaps ? $.sourcemaps.init() : noop())
    .pipe($.postcss(components.get('vendors').postcss))
    .pipe(c.run.sourcemaps ? $.sourcemaps.write('.') : noop())
    .pipe(gulp.dest(components.get('vendors').dest.css))
    .on('end', () => {
      console.log('buildVendorsCss: ');
      console.log( $.filenames.get('css-v').map( upath.normalize) );
      $.filenames.forget('all');
    })
}


function buildModulesCss() {
  return gulp.src([components.get('modules').src.css, '!**/mod_starlink_{map,services,calculator_outsourcing}/**/*.*'])
    .pipe($.filenames('css'))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
    .pipe($.postcss(components.get('modules').postcss))
            .pipe($.postcss([require('cssnano')(), require('postcss-prettify')]))
    .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(components.get('modules').dest.css))
    .on('end', () => {
      console.log('buildModulesCss: ');
      console.log( $.filenames.get('css').map( s => 'modules:css'+upath.normalize(s)) );
      $.filenames.forget('all')
    })
}


const buildVendorsJs = (done)=> { log('vendors: fake buildVendorsJs'); done(); done() };
const buildModulesJs = (done)=> { log('vendors: fake buildModulesJs'); done(); done() };



gulp.task('default', initServer('js'));
gulp.task('build:vendors', gulp.parallel(buildVendorsCss, buildVendorsJs));
gulp.task('build:modules', gulp.parallel(buildModulesCss, buildModulesJs));


/*exports.initServer = initServer;*/

/*gulp.task('watch', function () {
  browserSync.init(c.plugin);
$.util.log(stringly(c.plugin));
  // Run tasks when files change.
  gulp.watch( c.modules.modcalc.src.js )
    .on('change', (path, stats) => gulp.series(modcalc.js, browserSync.reload));
  gulp.watch( c.modules.modcalc.src.css )
    .on('change', (path, stats) => modcalc.css().pipe(browserSync.reload({stream: true})));
} );*/

