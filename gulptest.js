'use strict';

const upath = require('upath');
/*  APP_ROOT keeps absolute path to the directory of gulptest.js
 *  i.e. root dir of the package
 */
global.APP_ROOT = global.APP_ROOT || upath.resolve(__dirname);

//<editor-fold desc="Gulp & helpers">

const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const log = $.util.log;

//</editor-fold>

const c = require('./config.gulp.js');
const browserSync = require('browser-sync').create();
const globby = require('globby');
const del = require('del');
const stringly = require('./.gulp/stringly');


const prettyFilenames = argArray =>
  argArray.reduce(
    (acc, curr) => `${acc}\n${' '.repeat(16)}${upath.normalize(curr)}`,
    ''
  );


const zipHelper = key => {
  const s = c.sources.get(key);
  return function() {
    return gulp.src(s.src.zip)
    .pipe($.filenames(key + ':zip'))
    .pipe($.zip(s.dest.zipName + '.zip'))
    .pipe(gulp.dest(s.dest.zip))
    .pipe($.filenames(key + ':zip:dest'))
    .on('end', () => {
      console.log(key + ':zip: ');
      console.log(key + ':zip:source:',
              prettyFilenames($.filenames.get(key + ':zip', 'full'))
      );
      console.log(key + ':zip:dest:',
              prettyFilenames($.filenames.get(key + ':zip:dest', 'full'))
      );
    });
  }
};



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
  });

//</editor-fold>


const cleanBasscss = () =>
        del(c.sources.get('basscss').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});

const cleanBootstrap = () =>
        del(c.sources.get('bootstrap').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});

//</editor-fold>

const buildVendors = gulp.parallel(
        buildVendorsBasscss,
        buildVendorsBootstrap
);
exports.buildVendors = buildVendors;

const cleanVendors = gulp.parallel(
        cleanBasscss,
        cleanBootstrap
);
exports.cleanVendors = cleanVendors;


//<editor-fold desc="Templates">

const buildTemplateCss = () =>
  gulp.src (c.sources.get('template').src.css )
  .pipe( $.filenames('template:css') )
  .pipe(
    $.if( c.run.sourcemaps,
      $.sourcemaps.init()
    )
  )
  .pipe( $.postcss( c.sources.get('template').postcss ) )
  .pipe(
    $.if( c.run.sourcemaps,
      $.sourcemaps.write('.')
    )
  )
  .pipe( gulp.dest( c.sources.get('template').dest.css ) )
  .pipe( $.filenames('template:css:dest') )
  .on( 'end', () => {
    console.log( 'Template:css: ' );
    console.log( 'Template:css:source:',
            prettyFilenames( $.filenames.get( 'template:css', 'full' ) )
    );
    console.log('Template:css:dest:',
            prettyFilenames( $.filenames.get( 'template:css:dest', 'full' ) )
    );
  });


const buildTemplateJs = () =>
  gulp.src( c.sources.get('template').src.js )
  .pipe( $.filenames('template:js') )
  .pipe( $.if( c.run.js.sourcemaps, $.sourcemaps.init() ) )
  .pipe( $.if( c.run.uglify, $.uglify(c.plugins.uglify) ) )
  .pipe( $.if( c.run.js.sourcemaps, $.sourcemaps.write('.') ) )
  .pipe( gulp.dest( c.sources.get('template').dest.js ) )
  .pipe( $.filenames('template:js:dest') )
  .on( 'end', () => {
    console.log( 'Template:js: ' );
    console.log( 'Template:js:source:',
            prettyFilenames( $.filenames.get('template:js', 'full') )
    );
    console.log( 'Template:js:dest:',
            prettyFilenames( $.filenames.get('template:js:dest', 'full') )
    );
  });


const buildTemplateJsBootstrap = () =>
  gulp.src( c.sources.get('template').src.jsBootstrap )
  .pipe( $.filenames('template:js:bootstrap') )
  .pipe( $.if( c.run.js.sourcemaps, $.sourcemaps.init() ) )
  .pipe( $.if( c.run.uglify, $.uglify(c.plugins.uglify) ) )
  .pipe( $.if( c.run.js.sourcemaps, $.sourcemaps.write('.') ) )
  .pipe( gulp.dest( c.sources.get('template').dest.jsBootstrap ) )
  .pipe( $.filenames('template:js:bootstrap:dest') )
  .on( 'end', () => {
    console.log( 'Template:js:bootstrap: ');
    console.log( 'Template:js:bootstrap:source:',
            prettyFilenames( $.filenames.get('template:js:bootstrap', 'full') )
    );
    console.log( 'Template:js:bootstrap:dest:',
            prettyFilenames( $.filenames.get('template:js:bootstrap:dest', 'full') )
    );
  });


const buildTemplateImages = () =>
  gulp.src(c.sources.get('template').src.images)
  .pipe($.filenames('template:images'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.dest(c.sources.get('template').dest.images))
  .pipe($.filenames('template:images:dest'))
  .on('end', () => {
    console.log('Template:images: ');
    console.log('Template:images:source:',
            prettyFilenames($.filenames.get('template:images', 'full'))
    );
    console.log('Template:images:dest:',
            prettyFilenames($.filenames.get('template:images:dest', 'full'))
    );
  });


const buildTemplateMarkup = () =>
  gulp.src(c.sources.get('template').src.markup)
  .pipe($.filenames('template:markup'))
  .pipe(gulp.dest(c.sources.get('template').dest.markup))
  .pipe($.filenames('template:markup:dest'))
  .on('end', () => {
    console.log('Template:markup: ');
    console.log('Template:markup:source:',
            prettyFilenames($.filenames.get('template:markup', 'full'))
    );
    console.log('Template:markup:dest:',
            prettyFilenames($.filenames.get('template:markup:dest', 'full'))
    );
  });


const buildTemplateOther = () =>
  gulp.src(c.sources.get('template').src.other)
  .pipe($.filenames('template:other'))
  .pipe(gulp.dest(c.sources.get('template').dest.other))
  .pipe($.filenames('template:other:dest'))
  .on('end', () => {
    console.log('Template:other: ');
    console.log('Template:other:source:',
            prettyFilenames($.filenames.get('template:other', 'full'))
    );
    console.log('Template:other:dest:',
            prettyFilenames($.filenames.get('template:other:dest', 'full'))
    );
  });


const buildTemplateZip = () =>
  gulp.src( c.sources.get('template').src.zip )
  .pipe( $.filenames('starlink:zip') )
  .pipe( $.zip('template_starlink.zip') )
  .pipe( gulp.dest(c.sources.get('template').dest.zip) )
  .pipe( $.filenames('starlink:zip:dest') )
  .on( 'end', () => {
    console.log('Template starlink:zip: ');
    console.log('Template starlink:zip:source:',
            prettyFilenames($.filenames.get('starlink:zip', 'full'))
    );
    console.log('Template starlink:zip:dest:',
            prettyFilenames($.filenames.get('starlink:zip:dest', 'full'))
    );
  });

const cleanTemplate = () =>
        del(c.sources.get('template').src.clean)
        .then( paths=>{ console.log(paths.join('\n')) } );


//</editor-fold>

const buildTemplate = gulp.parallel(
        buildTemplateCss,
        buildTemplateJs,
        buildTemplateJsBootstrap,
        buildTemplateImages,
        buildTemplateMarkup,
        buildTemplateOther
);
exports.buildTemplate = buildTemplate;
exports.buildTemplateZip = buildTemplateZip;
exports.cleanTemplate = cleanTemplate;


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

const cleanModstarlink = () =>
        del(c.sources.get('modstarlink').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});

//</editor-fold>

const buildModulesStarlink = gulp.parallel(
        buildModulesStarlinkCss,
        buildModulesStarlinkVendorCss,
        buildModulesStarlinkJs,
        buildModulesStarlinkImages,
        buildModulesStarlinkOther
);
exports.buildModulesStarlink = buildModulesStarlink;
const buildModulesStarlinkZip = zipHelper('modstarlink');
exports.buildModulesStarlinkZip = buildModulesStarlinkZip;
exports.cleanModstarlink = cleanModstarlink;


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

const cleanModcalc = () =>
        del(c.sources.get('modcalc').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});

//</editor-fold>

const buildModulesCalc = gulp.parallel(
        buildModulesCalcCss,
        buildModulesCalcJs,
        buildModulesCalcImages,
        buildModulesCalcOther
);
exports.buildModulesCalc = buildModulesCalc;
const buildModulesCalcZip = zipHelper('modcalc');
exports.buildModulesCalcZip = buildModulesCalcZip;
exports.cleanModcalc = cleanModcalc;


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


const cleanModservices = () =>
        del(c.sources.get('modservices').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});

//</editor-fold>

const buildModulesServices = gulp.parallel(
        buildModulesServicesCss,
        buildModulesServicesImages,
        buildModulesServicesOther
);
exports.buildModulesServices = buildModulesServices;
const buildModulesServicesZip = zipHelper('modservices');
exports.buildModulesServicesZip = buildModulesServicesZip;
exports.cleanmodServices = cleanModservices;


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

const cleanModmap = () =>
        del(c.sources.get('modmap').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});

//</editor-fold>

exports.buildModulesMap = buildModulesMap;
const buildModulesMapZip = zipHelper('modmap');
exports.buildModulesMapZip = buildModulesMapZip;
exports.cleanModmap = cleanModmap;

const buildModules = gulp.parallel(
        buildModulesStarlink,
        buildModulesCalc,
        buildModulesServices,
        buildModulesMap
);
exports.buildModules = buildModules;

const cleanModules = gulp.parallel(
        cleanModstarlink,
        cleanModcalc,
        cleanModservices,
        cleanModmap
);
exports.cleanModules = cleanModules;



const buildZip = gulp.parallel(
        buildModulesStarlinkZip,
        buildModulesCalcZip,
        buildModulesServicesZip,
        buildModulesMapZip,
        buildTemplateZip
);
exports.buildZip = buildZip;


const build = gulp.series(
        buildVendors,
        buildModules,
        buildTemplate,
        buildZip
);
exports.build = build;


const clean = gulp.series(
        cleanVendors,
        cleanTemplate,
        cleanModules
);
exports.clean = clean;

exports.buildClean = gulp.series(clean, build);



//</editor-fold>



/*gulp.task('watch', function () {
  browserSync.init(c.plugin);
$.util.log(stringly(c.plugin));
  // Run tasks when files change.
  gulp.watch( c.modules.modcalc.src.js )
    .on('change', (path, stats) => gulp.series(modcalc.js, browserSync.reload));
  gulp.watch( c.modules.modcalc.src.css )
    .on('change', (path, stats) => modcalc.css().pipe(browserSync.reload({stream: true})));
} );*/

