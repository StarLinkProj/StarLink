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


gulp.task('default', initServer($.util.env.target || 'css'));


const prettyFilenames = argArray =>
  argArray.reduce(
    (acc, curr) => `${acc}\n${' '.repeat(16)}${upath.normalize(curr)}`,
    ''
  );


//<editor-fold desc="Vendors">

//<editor-fold desc="BassCss">

const buildVendorsBasscss = () =>
  gulp.src(c.sources.get('basscss').src.css)
  .pipe($.filenames('basscss'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('basscss').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('basscss').dest.css))
  .pipe($.filenames('basscss-dest'))
  .on('end', () => {
    console.log('Basscss: ');
    console.log('Basscss:source:',
            prettyFilenames($.filenames.get('basscss', 'full'))
    );
    console.log('Basscss:dest:',
            prettyFilenames($.filenames.get('basscss-dest', 'full'))
    );
  });

//</editor-fold>


//<editor-fold desc="Bootstrap">

const buildVendorsBootstrap = () =>
  gulp.src(c.sources.get('bootstrap').src.sass)
  .pipe($.filenames('bootstrap'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.sass(c.sources.get('bootstrap').options).on('error', $.sass.logError))
  .pipe($.postcss(c.sources.get('bootstrap').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('bootstrap').dest.css))
  .pipe($.filenames('bootstrap-dest'))
  .on('end', () => {
    console.log('Bootstrap: ');
    console.log('Bootstrap:source:',
            prettyFilenames($.filenames.get('bootstrap', 'full'))
    );
    console.log('Bootstrap:dest:',
            prettyFilenames($.filenames.get('bootstrap-dest', 'full'))
    );
  });;

//</editor-fold>


const buildVendors = gulp.parallel(buildVendorsBasscss, buildVendorsBootstrap);
exports.buildVendors = buildVendors;

//</editor-fold>


//<editor-fold desc="Templates">

const buildTemplatesCss = () =>
  gulp.src(c.sources.get('templates').src.css)
  .pipe($.filenames('templates:css'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('templates').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('templates').dest.css))
  .pipe($.filenames('templates:css:dest'))
  .on('end', () => {
    console.log('Templates:css: ');
    console.log('Templates:css:source:',
            prettyFilenames($.filenames.get('templates:css', 'full'))
    );
    console.log('Templates:css:dest:',
            prettyFilenames($.filenames.get('templates:css:dest', 'full'))
    );
  });


const buildTemplatesJs = () =>
  gulp.src(c.sources.get('templates').src.js)
  .pipe($.filenames('templates:js'))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('templates').dest.js))
  .pipe($.filenames('templates:js:dest'))
  .on('end', () => {
    console.log('Templates:js: ');
    console.log('Templates:js:source:',
            prettyFilenames($.filenames.get('templates:js', 'full'))
    );
    console.log('Templates:js:dest:',
            prettyFilenames($.filenames.get('templates:js:dest', 'full'))
    );
  });


const buildTemplatesJsBootstrap = () =>
  gulp.src(c.sources.get('templates').src.jsBootstrap)
  .pipe($.filenames('templates:js:bootstrap'))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('templates').dest.jsBootstrap))
  .pipe($.filenames('templates:js:bootstrap:dest'))
  .on('end', () => {
    console.log('Templates:js:bootstrap: ');
    console.log('Templates:js:bootstrap:source:',
            prettyFilenames($.filenames.get('templates:js:bootstrap', 'full'))
    );
    console.log('Templates:js:bootstrap:dest:',
            prettyFilenames($.filenames.get('templates:js:bootstrap:dest', 'full'))
    );
  });


const buildTemplatesImages = () =>
  gulp.src(c.sources.get('templates').src.images)
  .pipe($.filenames('templates:images'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.dest(c.sources.get('templates').dest.images))
  .pipe($.filenames('templates:images:dest'))
  .on('end', () => {
    console.log('Templates:images: ');
    console.log('Templates:images:source:',
            prettyFilenames($.filenames.get('templates:images', 'full'))
    );
    console.log('Templates:images:dest:',
            prettyFilenames($.filenames.get('templates:images:dest', 'full'))
    );
  });


const buildTemplatesMarkup = () =>
  gulp.src(c.sources.get('templates').src.markup)
  .pipe($.filenames('templates:markup'))
  .pipe(gulp.dest(c.sources.get('templates').dest.markup))
  .pipe($.filenames('templates:markup:dest'))
  .on('end', () => {
    console.log('Templates:markup: ');
    console.log('Templates:markup:source:',
            prettyFilenames($.filenames.get('templates:markup', 'full'))
    );
    console.log('Templates:markup:dest:',
            prettyFilenames($.filenames.get('templates:markup:dest', 'full'))
    );
  });


const buildTemplatesOther = () =>
  gulp.src(c.sources.get('templates').src.other)
  .pipe($.filenames('templates:other'))
  .pipe(gulp.dest(c.sources.get('templates').dest.other))
  .pipe($.filenames('templates:other:dest'))
  .on('end', () => {
    console.log('Templates:other: ');
    console.log('Templates:other:source:',
            prettyFilenames($.filenames.get('templates:other', 'full'))
    );
    console.log('Templates:other:dest:',
            prettyFilenames($.filenames.get('templates:other:dest', 'full'))
    );
  });


const buildTemplates = gulp.parallel(
        buildTemplatesCss,
        buildTemplatesJs,
        buildTemplatesJsBootstrap,
        buildTemplatesImages,
        buildTemplatesMarkup,
        buildTemplatesOther
);

exports.buildTemplates = buildTemplates;

//</editor-fold>


//<editor-fold desc="Modules">


//<editor-fold desc="mod_starlink">

const buildModulesStarlinkCss = () =>
  gulp.src(c.sources.get('modstarlink').src.css)
  .pipe($.filenames('modules:modstarlink:css'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('modstarlink').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.css))
  .pipe($.filenames('modules:modstarlink:css:dest'))
  .on('end', () => {
    console.log('modules:modstarlink:css ');
    console.log('modules:modstarlink:css:source:',
      prettyFilenames($.filenames.get('modules:modstarlink:css', 'full'))
    );
    console.log('modules:modstarlink:css:dest:',
      prettyFilenames($.filenames.get('modules:modstarlink:css:dest', 'full'))
    );
  });


const buildModulesStarlinkVendorCss = () =>
  gulp.src(c.sources.get('modstarlink').src.vendorCss)
  .pipe($.filenames('modules:modstarlink:vendorcss'))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.vendorCss))
  .pipe($.filenames('modules:modstarlink:vendorcss:dest'))
  .on('end', () => {
    console.log('modules:modstarlink:vendorcss ');
    console.log('modules:modstarlink:vendorcss:source:',
      prettyFilenames($.filenames.get('modules:modstarlink:vendorcss', 'full'))
    );
    console.log('modules:modstarlink:vendorcss:dest:',
      prettyFilenames($.filenames.get('modules:modstarlink:vendorcss:dest', 'full'))
    );
  });


const buildModulesStarlinkJs = () =>
  gulp.src(c.sources.get('modstarlink').src.js)
  .pipe($.filenames('modules:modstarlink:js'))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.js))
  .pipe($.filenames('modules:modstarlink:js:dest'))
  .on('end', () => {
    console.log('modules:modstarlink:js ');
    console.log('modules:modstarlink:js:source:',
      prettyFilenames($.filenames.get('modules:modstarlink:js', 'full'))
    );
    console.log('modules:modstarlink:js:dest:',
      prettyFilenames($.filenames.get('modules:modstarlink:js:dest', 'full'))
    );
  });


/* Actually this is for images & fonts */
const buildModulesStarlinkImages = () =>
  gulp.src(c.sources.get('modstarlink').src.images)
  .pipe($.filenames('modules:modstarlink:images'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.src(c.sources.get('modstarlink').src.fonts, {passthrough: true}))
  .pipe($.filenames('modules:modstarlink:images'))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.images))
  .pipe($.filenames('modules:modstarlink:images:dest'))
  .on('end', () => {
    console.log('modules:modstarlink:images');
    console.log('modules:modstarlink:images:source:',
      prettyFilenames($.filenames.get('modules:modstarlink:images', 'full'))
    );
    console.log('modules:modstarlink:images:dest:',
      prettyFilenames($.filenames.get('modules:modstarlink:images:dest', 'full'))
    );
  });


const buildModulesStarlinkOther = () =>
  gulp.src(c.sources.get('modstarlink').src.other)
  .pipe($.filenames('modules:modstarlink:other'))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.other))
  .pipe($.filenames('modules:modstarlink:other:dest'))
  .on('end', () => {
    console.log('modules:modstarlink:other');
    console.log('modules:modstarlink:other:source:',
      prettyFilenames($.filenames.get('modules:modstarlink:other', 'full'))
    );
    console.log('modules:modstarlink:other:dest:',
      prettyFilenames($.filenames.get('modules:modstarlink:other:dest', 'full'))
    );
  });


const buildModulesStarlink = gulp.parallel(
        buildModulesStarlinkCss,
        buildModulesStarlinkVendorCss,
        buildModulesStarlinkJs,
        buildModulesStarlinkImages,
        buildModulesStarlinkOther
);

//</editor-fold>


//<editor-fold desc="mod_starlink_calculator_outsourcing">

const buildModulesCalcCss = () =>
  gulp.src(c.sources.get('modcalc').src.css)
  .pipe($.filenames('modules:modcalc:css'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('modcalc').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modcalc').dest.css))
  .pipe($.filenames('modules:modcalc:css:dest'))
  .on('end', () => {
    console.log('modules:modcalc:css ');
    console.log('modules:modcalc:css:source:',
      prettyFilenames($.filenames.get('modules:modcalc:css', 'full'))
    );
    console.log('modules:modcalc:css:dest:',
      prettyFilenames($.filenames.get('modules:modcalc:css:dest', 'full'))
    );
  });


const buildModulesCalcJs = () =>
  gulp.src(c.sources.get('modcalc').src.js)
  .pipe($.filenames('modules:modcalc:js'))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modcalc').dest.js))
  .pipe($.filenames('modules:modcalc:js:dest'))
  .on('end', () => {
    console.log('modules:modcalc:js ');
    console.log('modules:modcalc:js:source:',
      prettyFilenames($.filenames.get('modules:modcalc:js', 'full'))
    );
    console.log('modules:modcalc:js:dest:',
      prettyFilenames($.filenames.get('modules:modcalc:js:dest', 'full'))
    );
  });


const buildModulesCalcImages = () =>
  gulp.src(c.sources.get('modcalc').src.images)
  .pipe($.filenames('modules:modcalc:images'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.dest(c.sources.get('modcalc').dest.images))
  .pipe($.filenames('modules:modcalc:images:dest'))
  .on('end', () => {
    console.log('modules:modcalc:images');
    console.log('modules:modcalc:images:source:',
      prettyFilenames($.filenames.get('modules:modcalc:images', 'full'))
    );
    console.log('modules:modcalc:images:dest:',
      prettyFilenames($.filenames.get('modules:modcalc:images:dest', 'full'))
    );
  });


const buildModulesCalcOther = () =>
  gulp.src(c.sources.get('modcalc').src.other)
  .pipe($.filenames('modules:modcalc:other'))
  .pipe(gulp.dest(c.sources.get('modcalc').dest.other))
  .pipe($.filenames('modules:modcalc:other:dest'))
  .on('end', () => {
    console.log('modules:modcalc:other ');
    console.log('modules:modcalc:other:source:',
      prettyFilenames($.filenames.get('modules:modcalc:other', 'full'))
    );
    console.log('modules:modcalc:other:dest:',
      prettyFilenames($.filenames.get('modules:modcalc:other:dest', 'full'))
    );
  });


const buildModulesCalc = gulp.parallel(
        buildModulesCalcCss,
        buildModulesCalcJs,
        buildModulesCalcImages,
        buildModulesCalcOther
);

//</editor-fold>


//<editor-fold desc="mod_starlink_services">


const buildModulesServicesCss = () =>
  gulp.src(c.sources.get('modservices').src.css)
  .pipe($.filenames('modules:modservices:css'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('modservices').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modservices').dest.css))
  .pipe($.filenames('modules:modservices:css:dest'))
  .on('end', () => {
    console.log('modules:modservices:css ');
    console.log('modules:modservices:css:source:',
      prettyFilenames($.filenames.get('modules:modservices:css', 'full'))
    );
    console.log('modules:modservices:css:dest:',
      prettyFilenames($.filenames.get('modules:modservices:css:dest', 'full'))
    );
  });


const buildModulesServicesImages = () =>
  gulp.src(c.sources.get('modservices').src.images)
  .pipe($.filenames('modules:modservices:images'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.dest(c.sources.get('modservices').dest.images))
  .pipe($.filenames('modules:modservices:images:dest'))
  .on('end', () => {
    console.log('modules:modservices:images');
    console.log('modules:modservices:images:source:',
      prettyFilenames($.filenames.get('modules:modservices:images', 'full'))
    );
    console.log('modules:modservices:images:dest:',
      prettyFilenames($.filenames.get('modules:modservices:images:dest', 'full'))
    );
  });


const buildModulesServicesOther = () =>
  gulp.src(c.sources.get('modservices').src.other)
  .pipe($.filenames('modules:modservices:other'))
  .pipe(gulp.dest(c.sources.get('modservices').dest.other))
  .pipe($.filenames('modules:modservices:other:dest'))
  .on('end', () => {
    console.log('modules:modservices:other ');
    console.log('modules:modservices:other:source:',
      prettyFilenames($.filenames.get('modules:modservices:other', 'full'))
    );
    console.log('modules:modservices:other:dest:',
      prettyFilenames($.filenames.get('modules:modservices:other:dest', 'full'))
    );
  });


const buildModulesServices = gulp.parallel(
  buildModulesServicesCss,
  buildModulesServicesImages,
  buildModulesServicesOther
);

//</editor-fold>


//<editor-fold desc="mod_starlink_map">

const buildModulesMap = () =>
  gulp.src(c.sources.get('modmap').src.all)
  .pipe($.filenames('modules:modmap'))
  .pipe(gulp.dest(c.sources.get('modmap').dest.all))
  .pipe($.filenames('modules:modmap:dest'))
  .on('end', () => {
    console.log('modules:modmap: ');
    console.log('modules:modmap:source:',
      prettyFilenames($.filenames.get('modules:modmap', 'full'))
    );
    console.log('modules:modmap:dest:',
      prettyFilenames($.filenames.get('modules:modmap:dest', 'full'))
    );
  });

//</editor-fold>


const buildModules = gulp.parallel(
        buildModulesStarlink,
        buildModulesCalc,
        buildModulesServices,
        buildModulesMap
);

exports.buildModules = buildModules;

//</editor-fold>


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

