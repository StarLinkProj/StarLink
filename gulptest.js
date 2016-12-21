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


/*const prettyFilenames = argArray =>
  argArray.reduce(
    (acc, curr) => `${acc}${curr}\n}`,
    ''
  );*/


const logPipeline = (module, task) => {
  return function () {
    console.log(
            $.filenames.get(`${module}:${task}:source`, 'full')
            .map(v => `${module}:${task}:source: ${upath.normalize(v)}`)
            .reduce( (acc, curr) => `${acc}${curr}\n`, '' )
    );
    console.log(
            $.filenames.get(`${module}:${task}:dest`, 'full')
            .map(v => `${module}:${task}:dest:   ${upath.normalize(v)}`)
            .reduce( (acc, curr) => `${acc}${curr}\n`, '' )
    );
  }
};


const zipHelper = key => {
  const s = c.sources.get(key);
  return function() {
    return gulp.src(s.src.zip)
    .pipe($.filenames(key + ':zip:source'))
    .pipe($.zip(s.dest.zipName + '.zip'))
    .pipe(gulp.dest(s.dest.zip))
    .pipe($.filenames(key + ':zip:dest'))
    .on('end', logPipeline(key, 'zip'));
  }
};



//<editor-fold desc="Vendors">


//<editor-fold desc="BassCss">

const buildVendorsBasscss = () =>
  gulp.src(c.sources.get('basscss').src.css)
  .pipe($.filenames('basscss:build:source'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('basscss').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('basscss').dest.css))
  .pipe($.filenames('basscss:build:dest'))
  .on('end', logPipeline('basscss', 'build'));
/*    () => {
    console.log('Basscss: ');
    console.log('Basscss:source:',
            prettyFilenames($.filenames.get('basscss', 'full'))
    );
    console.log('Basscss:dest:',
            prettyFilenames($.filenames.get('basscss-dest', 'full'))
    );
  }
  );*/


const cleanBasscss = () =>
        del(c.sources.get('basscss').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});

//</editor-fold>


//<editor-fold desc="Bootstrap">

const buildVendorsBootstrap = () =>
  gulp.src(c.sources.get('bootstrap').src.sass)
  .pipe($.filenames('bootstrap:build:source'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.sass(c.sources.get('bootstrap').options).on('error', $.sass.logError))
  .pipe($.postcss(c.sources.get('bootstrap').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('bootstrap').dest.css))
  .pipe($.filenames('bootstrap:build:dest'))
  .on('end', logPipeline('bootstrap', 'build'));


/*          () => {
    console.log('Bootstrap: ');
    console.log('Bootstrap:source:',
            prettyFilenames($.filenames.get('bootstrap', 'full'))
    );
    console.log('Bootstrap:dest:',
            prettyFilenames($.filenames.get('bootstrap-dest', 'full'))
    );
  });*/


const cleanBootstrap = () =>
        del(c.sources.get('bootstrap').src.clean)
        .then( paths => {console.log(paths.join('\n'))} );

//</editor-fold>


const buildVendors = gulp.parallel(
        buildVendorsBasscss,
        buildVendorsBootstrap
);


const cleanVendors = gulp.parallel(
        cleanBasscss,
        cleanBootstrap
);

//</editor-fold>


exports.buildVendors = buildVendors;
exports.cleanVendors = cleanVendors;


//<editor-fold desc="Templates">

const buildTemplateCss = () => {
  return gulp.src(c.sources.get('template').src.css)
    .pipe($.filenames('template:css:source'))
    .pipe(
            $.if(c.run.sourcemaps,
                    $.sourcemaps.init()
            )
    )
    .pipe($.postcss(c.sources.get('template').postcss))
    .pipe(
            $.if(c.run.sourcemaps,
                    $.sourcemaps.write('.')
            )
    )
    .pipe(gulp.dest(c.sources.get('template').dest.css))
    .pipe($.filenames('template:css:dest'))
    .on('end', logPipeline('template', 'css'));
};


const buildTemplateJs = () => {
  return gulp.src(c.sources.get('template').src.js)
    .pipe($.filenames('template:js:source'))
    .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
    .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
    .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(c.sources.get('template').dest.js))
    .pipe($.filenames('template:js:dest'))
    .on('end', logPipeline('template', 'js'));
};


const buildTemplateJsBootstrap = () => {
  return gulp.src(c.sources.get('template').src.jsBootstrap)
    .pipe($.filenames('template:jsBootstrap:source'))
    .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
    .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
    .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
    .pipe(gulp.dest(c.sources.get('template').dest.jsBootstrap))
    .pipe($.filenames('template:jsBootstrap:dest'))
    .on('end', logPipeline('template', 'jsBootstrap'));
};


const buildTemplateImages = () => {
  return gulp.src(c.sources.get('template').src.images)
    .pipe($.filenames('template:images:source'))
    .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
    .pipe(gulp.dest(c.sources.get('template').dest.images))
    .pipe($.filenames('template:images:dest'))
    .on('end', logPipeline('template', 'images'));
};


const buildTemplateMarkup = () => {
  return gulp.src(c.sources.get('template').src.markup)
    .pipe($.filenames('template:markup:source'))
    .pipe(gulp.dest(c.sources.get('template').dest.markup))
    .pipe($.filenames('template:markup:dest'))
    .on('end', logPipeline('template', 'markup'));
};


const buildTemplateOther = () => {
  return gulp.src(c.sources.get('template').src.other)
    .pipe($.filenames('template:other:source'))
    .pipe(gulp.dest(c.sources.get('template').dest.other))
    .pipe($.filenames('template:other:dest'))
    .on('end', logPipeline('template', 'other'));
};



const cleanTemplate = () =>
        del(c.sources.get('template').src.clean)
        .then( paths=>{ console.log(paths.join('\n')) } );


const buildTemplate = gulp.parallel(
        buildTemplateCss,
        buildTemplateJs,
        buildTemplateJsBootstrap,
        buildTemplateImages,
        buildTemplateMarkup,
        buildTemplateOther
);


const zipTemplate = zipHelper('template');


//</editor-fold>


exports.buildTemplate = buildTemplate;
exports.zipTemplate = zipTemplate;
exports.cleanTemplate = cleanTemplate;


//<editor-fold desc="Modules">


//<editor-fold desc="mod_starlink">

const buildModulesStarlinkCss = () =>
  gulp.src(c.sources.get('modstarlink').src.css)
  .pipe($.filenames('modstarlink:css:source'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('modstarlink').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.css))
  .pipe($.filenames('modstarlink:css:dest'))
  .on('end', logPipeline('modstarlink', 'css'));


const buildModulesStarlinkVendorCss = () =>
  gulp.src(c.sources.get('modstarlink').src.vendorCss)
  .pipe($.filenames('modstarlink:vendorCSS:source'))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.vendorCss))
  .pipe($.filenames('mmodstarlink:vendorCSS:dest'))
  .on('end', logPipeline('modstarlink', 'vendorCSS'));


const buildModulesStarlinkJs = () =>
  gulp.src(c.sources.get('modstarlink').src.js)
  .pipe($.filenames('modstarlink:js:source'))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.js))
  .pipe($.filenames('modstarlink:js:dest'))
  .on('end', logPipeline('modstarlink', 'js'));


/* Actually this is for images & fonts */
const buildModulesStarlinkImages = () =>
  gulp.src(c.sources.get('modstarlink').src.images)
  .pipe($.filenames('modstarlink:images:source'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.src(c.sources.get('modstarlink').src.fonts, {passthrough: true}))
  .pipe($.filenames('modstarlink:images:source'))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.images))
  .pipe($.filenames('modstarlink:images:dest'))
  .on('end', logPipeline('modstarlink', 'images'));


const buildModulesStarlinkOther = () =>
  gulp.src(c.sources.get('modstarlink').src.other)
  .pipe($.filenames('modstarlink:other:source'))
  .pipe(gulp.dest(c.sources.get('modstarlink').dest.other))
  .pipe($.filenames('modstarlink:other:dest'))
  .on('end', logPipeline('modstarlink', 'other'));


const cleanModstarlink = () =>
        del(c.sources.get('modstarlink').src.clean)
        .then( paths => { console.log(paths.join('\n')) } );


const buildModulesStarlink = gulp.parallel(
        buildModulesStarlinkCss,
        buildModulesStarlinkVendorCss,
        buildModulesStarlinkJs,
        buildModulesStarlinkImages,
        buildModulesStarlinkOther
);


const zipModstarlink = zipHelper('modstarlink');


//</editor-fold>


exports.buildModulesStarlink = buildModulesStarlink;
exports.zipModstarlink = zipModstarlink;
exports.cleanModstarlink = cleanModstarlink;


//<editor-fold desc="mod_starlink_calculator_outsourcing">

const buildModulesCalcCss = () =>
  gulp.src(c.sources.get('modcalc').src.css)
  .pipe($.filenames('modcalc:css:source'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('modcalc').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modcalc').dest.css))
  .pipe($.filenames('modcalc:css:dest'))
  .on('end', logPipeline('modcalc', 'css'));


const buildModulesCalcJs = () =>
  gulp.src(c.sources.get('modcalc').src.js)
  .pipe($.filenames('modcalc:js:source'))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.init()))
  .pipe($.if(c.run.uglify, $.uglify(c.plugins.uglify)))
  .pipe($.if(c.run.js.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modcalc').dest.js))
  .pipe($.filenames('modcalc:js:dest'))
  .on('end', logPipeline('modcalc', 'js'));


const buildModulesCalcImages = () =>
  gulp.src(c.sources.get('modcalc').src.images)
  .pipe($.filenames('modcalc:images:source'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.dest(c.sources.get('modcalc').dest.images))
  .pipe($.filenames('modcalc:images:dest'))
  .on('end', logPipeline('modcalc', 'images'));


const buildModulesCalcOther = () =>
  gulp.src(c.sources.get('modcalc').src.other)
  .pipe($.filenames('modcalc:other:source'))
  .pipe(gulp.dest(c.sources.get('modcalc').dest.other))
  .pipe($.filenames('modcalc:other:dest'))
  .on('end', logPipeline('modcalc', 'other'));


const cleanModcalc = () =>
        del(c.sources.get('modcalc').src.clean)
        .then( paths => { console.log(paths.join('\n')) } );


const buildModulesCalc = gulp.parallel(
        buildModulesCalcCss,
        buildModulesCalcJs,
        buildModulesCalcImages,
        buildModulesCalcOther
);


const zipModcalc = zipHelper('modcalc');


//</editor-fold>


exports.buildModulesCalc = buildModulesCalc;
exports.zipModcalc = zipModcalc;
exports.cleanModcalc = cleanModcalc;


//<editor-fold desc="mod_starlink_services">

const buildModulesServicesCss = () =>
  gulp.src(c.sources.get('modservices').src.css)
  .pipe($.filenames('modservices:css:source'))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.init()))
  .pipe($.postcss(c.sources.get('modservices').postcss))
  .pipe($.if(c.run.sourcemaps, $.sourcemaps.write('.')))
  .pipe(gulp.dest(c.sources.get('modservices').dest.css))
  .pipe($.filenames('modservices:css:dest'))
  .on('end', logPipeline('modservices', 'js'));


const buildModulesServicesImages = () =>
  gulp.src(c.sources.get('modservices').src.images)
  .pipe($.filenames('modservices:images:source'))
  .pipe($.if(c.run.imagemin, $.imagemin(c.plugins.imagemin)))
  .pipe(gulp.dest(c.sources.get('modservices').dest.images))
  .pipe($.filenames('modservices:images:dest'))
  .on('end', logPipeline('modservices', 'images'));


const buildModulesServicesOther = () =>
  gulp.src(c.sources.get('modservices').src.other)
  .pipe($.filenames('modservices:other:source'))
  .pipe(gulp.dest(c.sources.get('modservices').dest.other))
  .pipe($.filenames('modservices:other:dest'))
  .on('end', logPipeline('modservices', 'other'));


const cleanModservices = () =>
        del(c.sources.get('modservices').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});


const buildModulesServices = gulp.parallel(
        buildModulesServicesCss,
        buildModulesServicesImages,
        buildModulesServicesOther
);


const zipModservices = zipHelper('modservices');


//</editor-fold>


exports.buildModulesServices = buildModulesServices;
exports.zipModservices = zipModservices;
exports.cleanmodServices = cleanModservices;


//<editor-fold desc="mod_starlink_map">

const buildModulesMap = () =>
  gulp.src(c.sources.get('modmap').src.all)
  .pipe($.filenames('modmap:build:source'))
  .pipe(gulp.dest(c.sources.get('modmap').dest.all))
  .pipe($.filenames('modmap:build:dest'))
  .on('end', logPipeline('modmap', 'build'));


const cleanModmap = () =>
        del(c.sources.get('modmap').src.clean)
        .then(paths=>{console.log(paths.join('\n'))});


const zipModmap = zipHelper('modmap');


//</editor-fold>


exports.buildModulesMap = buildModulesMap;
exports.zipModmap = zipModmap;
exports.cleanModmap = cleanModmap;




const buildModules = gulp.parallel(
        buildModulesStarlink,
        buildModulesCalc,
        buildModulesServices,
        buildModulesMap
);
const cleanModules = gulp.parallel(
        cleanModstarlink,
        cleanModcalc,
        cleanModservices,
        cleanModmap
);
const zip = gulp.parallel(
        zipModstarlink,
        zipModcalc,
        zipModservices,
        zipModmap,
        zipTemplate
);



exports.buildModules = buildModules;
exports.cleanModules = cleanModules;


const build = gulp.series(
        buildVendors,
        buildModules,
        buildTemplate,
        zip
);
const clean = gulp.series(
        cleanVendors,
        cleanTemplate,
        cleanModules
);

exports.build = build;
exports.clean = clean;
exports.buildClean = gulp.series(clean, build);

exports.zip = zip;


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

