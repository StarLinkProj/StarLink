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
      if (v.src[target]) {
        s.add(gulp.src(v.src[target], {read: false})
        .pipe($.filenames('initserver' + k))
        .pipe(gulp.dest(v.dest[target]))
        .pipe($.filenames('initserver-dest' + k))
        .on('end', () => {
          console.log(`task ${k}:${target}`);
          let z = $.filenames.get('initserver' + k).map( (e,i)=> upath.resolve(e) + ' | ' + upath.resolve($.filenames.get('initserver-dest' + k)[i]));
          console.log(
                  z.sort()
                  .reduce((s1, s2) => `${s1}    ${s2}\n`, '')
          );
        })
        );
      }
    });
    return s;
  }
}


function buildVendorsCss() {
  return gulp.src(components.get('vendors').src.css, {read: true})
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
  return gulp.src([components.get('modules').src.css, '!**/mod_starlink_{map,services,calculator_outsourcing}/**/*.*'], {read: true})
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



gulp.task('default', initServer($.util.env.target || 'css'));
gulp.task('build:vendors', gulp.parallel(buildVendorsCss, buildVendorsJs));
gulp.task('build:modules', gulp.parallel(buildModulesCss, buildModulesJs));


const testDir = () => {
  const Dirs = new Map([
          ['./.src/templates', './templates'],
          ['./.src/vendor/basscss/css', './media/mod_starlink/css/vendor'],
          ['./.src/vendor/bootstrap/css', './media/mod_starlink/css/vendor'],
          ['./.src/vendor/mod_starlink', './media/mod_starlink/css/vendor']
  ]);
  const fs = require('fs');
  fs.readdir(Dirs.get('./.src/templates'), (err, files) => {
    files.forEach(file => {
      console.log(file);
    });
  })
};



const buildVendorsBasscss = (done) =>
  gulp.src(c.sources.get('basscss').src.css)
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('basscss').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('basscss').dest.css));
  //console.log('buildBasscss: fake done');
  //done()
//;


const buildVendorsBootstrapCss = () =>
  gulp.src(c.sources.get('bootstrap').src.sass)
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.sass(c.sources.get('bootstrap').options).on('error', $.sass.logError))
  .pipe($.postcss(c.sources.get('bootstrap').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('bootstrap').dest.css));

const buildVendorsBootstrapJs = (done) => {
  console.log('        buildVendorsBootstrapJs: fake done');
  done()
}

const buildVendorsBootstrap = gulp.series(
        gulp.parallel(buildVendorsBootstrapCss, buildVendorsBootstrapJs),
        (done) => {
          log('    buildVendorsBootstrap: fake done');
          done()
        }
);


const buildVendors = gulp.series(
        gulp.parallel(buildVendorsBasscss, buildVendorsBootstrap),
        (done) => {
          log('buildVendors: fake done');
          done()
        }
);






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

exports.buildVendors = buildVendors;