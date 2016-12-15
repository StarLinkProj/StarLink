'use strict';


//<editor-fold desc="Imports">

import gulp from 'gulp';
const $ = require('gulp-load-plugins')();   // lazy import of gulp plugins. Use $.plugin(args) instead of require('gulp-plugin')(args)

const browserSync = require('browser-sync').create();
const reload = browserSync.reload;

import merge from 'lodash.merge';
import stringly from '../../../.gulp/stringly';

//</editor-fold>



//<editor-fold desc="Helper functions">


/**  pipe through this for no operation (simpler than gulp-if) **/
const noop = $.util.noop;


/**  pipe through this to see files in a stream                **/
const debug = operation => $.debug({ title: operation });


/** test all source globs in config paths                      **/
const testPatterns = (done) => {
  const configSelf = config.modules.templates;
  for ( let g of Object.keys(configSelf.src) ) {
    $.util.log(`src.${g}: ${stringly(configSelf.src[g])}`);
    ( a => gulp.src(a, {read:false}).pipe(debug('    ')) )(configSelf.src[g]);
  }
  done();
};


//</editor-fold>




//<editor-fold desc="Constants">

const COMPONENT = 'templates';
const SRC_ROOT = '../..';
const PROJ_ROOT = '../../..';
const ROOTS = {
  $include:    SRC_ROOT + '/_includes',
  bootstrap:   SRC_ROOT + '/bootstrap',
  basscss:     SRC_ROOT + '/bassplate2',
  modcalc:     SRC_ROOT + '/mod_starlink_calculator_outsourcing',
  modmaps:     SRC_ROOT + '/mod_starlink_map',
  modservices: SRC_ROOT + '/mod_starlink_services',
  modstarlink: SRC_ROOT + '/mod_starlink',
  template:    SRC_ROOT + '/templates/starlink',
  self:        '/.src/templates/starlink'     // path to this module location relatively to PROJ_ROOT
};
const JOOMLA_MEDIA = PROJ_ROOT + '/media';
const JOOMLA_MODULES = PROJ_ROOT + '/modules';
const PACKAGES = PROJ_ROOT + '/.dist';
const JOOMLA_TEMPLATES = PROJ_ROOT + '/templates';

//</editor-fold>




//<editor-fold desc="Main Configuration object">


let config = {
  modules: {
    templates: {
      src: {
        all:        ROOTS.template + '/**/*.*',
        allCss:     ROOTS.template + '/**/*.css',
        allJs:      ROOTS.template + '/**/*.js',
        allMarkup:  ROOTS.template + '/**/*.{html, php}',
        allImages:  ROOTS.template + '/**/*.{png, jpg, jpeg, gif, svg, ico}',
        css:        ROOTS.template + '/css/**/!(_)*.css',
        js:         ROOTS.template + '/js/**/*.js',
        vendorjs:   ROOTS.bootstrap + '/js/*.js',
        images:     ROOTS.template + '/images/**/*.*',
        other:      [
          ROOTS.template + '/**/*.*',
          '!' + ROOTS.template + '/**/*.css',
          '!' + ROOTS.template + '/**/*.js',
          '!' + ROOTS.template + '/**/*.{html, php}',
          '!' + ROOTS.template + '/**/*.{png, jpg, jpeg, gif, svg, ico}'
        ],
        zip:         JOOMLA_TEMPLATES + '/starlink/**/*.*'
      },
      dest: {
        css:         JOOMLA_TEMPLATES + '/starlink/css',
        js:          JOOMLA_TEMPLATES + '/starlink/js',
        vendorjs:    JOOMLA_TEMPLATES + '/starlink/js/jui',
        images:      JOOMLA_TEMPLATES + '/starlink/images',
        other:       JOOMLA_TEMPLATES + '/starlink/',
        zip:         PACKAGES
      },
      postcss: [
        require('postcss-import')({ path: [SRC_ROOT + '/_includes'] }),
        require('postcss-mixins'),
        require('postcss-custom-properties'),
        require('postcss-apply'),
        require('postcss-calc'),
        require('postcss-nesting'),
        require('postcss-custom-media'),
        require('postcss-extend'),
        require('postcss-media-minmax'),
        require('postcss-custom-selectors'),
        require('postcss-color-hwb'),
        require('postcss-color-gray'),
        require('postcss-color-hex-alpha'),
        require('postcss-color-function'), /*require('pixrem'),*/
        require('postcss-url'),
        require('postcss-for'),
        require('postcss-discard-comments'),
        require('autoprefixer')({'browsers': '> 1%'}),
        require('css-mqpacker')({sort: true})
      ]
    }
  },
  constants: {},
  plugin: {},
  run: {}
};


const configSelf = config.modules.templates;


//</editor-fold>




//<editor-fold desc="Settings & Initialization routine">


/* Application constants: database names, server addresses etc. */
let constants = {
  default:     {
    apiHost: ''
  },
  development: {
    /*    apiHost: 'http://localhost:9050'*/
  },
  staging:     {
    /*    apiHost: 'http://staging.example.com/api/'*/
  },
  production:  {
    /*    apiHost: 'http://example.com/api/'*/
  }
};


/* Object for toggling plugins on/off depending on environment */
let run = {
  default:     {
    debug: true,
    sourcemaps: true,
    imagemin: true,
    zip: true,
    js:  {
      uglify: false
    },
    css: {
      cssnano: false,
      autoprefixer: false
    }
  },
  development: {
    debug: true,
    sourcemaps: true,
    js:  {
      uglify: false
    },
    css: {
      cssnano: false,
      autoprefixer: true
    }
  },
  staging:     {
    sourcemaps: true,
    js:  {
      uglify: true
    },
    css: {
      cssnano: true,
      autoprefixer: false
    }
  },
  production:  {
    sourcemaps: false,
    js:  {
      uglify: true
    },
    css: {
      cssnano: true,
      autoprefixer: true
    }
  }
};


/* Plugin options dependent on environment */
let plugin = {
  default:     {
    js: {
      uglify: {
        mangle: true
      }
    },
    browserSync: {
      server: '.',
      browser: ['chrome']
    },
    imagemin: [
      require('gulp-imagemin').gifsicle(),
      require('gulp-imagemin').jpegtran(),
      require('gulp-imagemin').optipng()
    ]
  },
  development: {
    js: {
      uglify: {
        mangle: false
      }
    },
    browserSync: {
      server: null,
      proxy: 'localhost:8000'
    }
  },
  staging:     {
    js: {
      uglify: {
        mangle: true
      }
    }
  },
  production:  {
    js: {
      uglify: {
        mangle: true
      }
    }
  }
};


/** Initialization and reduction of constants, run & plugin objects with current runtime environment **/
const init = (done) => {
  const env = $.util.env.env || 'development';
  $.util.log(`env=${env}`);

  run = merge({}, run.default, run[env]);
  constants = merge({}, constants.default, constants[env]);
  plugin = merge({}, plugin.default, plugin[env]);

  if (plugin.browserSync.server === null)
    delete plugin.browserSync.server;
  if (plugin.browserSync.proxy === null)
    delete plugin.browserSync.proxy;

  config.run = Object.assign({}, run);
  config.plugin = Object.assign({}, plugin);
  config.constants = Object.assign({}, constants);

  done();
};


//</editor-fold>




//<editor-fold desc="Tasks: private for this module">


const connect = (done) => {
  browserSync.init(plugin.browserSync);
  done();
};


export function css() {
  return gulp.src( config.modules.templates.src.css, { since: gulp.lastRun('css') } )
    .pipe(config.run.sourcemaps ? $.sourcemaps.init() : noop())
    .pipe($.postcss(config.modules.templates.postcss))
    .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : noop())
    .pipe(config.run.debug ? debug('templates read: ') : noop())
    .pipe(gulp.dest(config.modules.templates.dest.css))
    .pipe(config.run.debug ? debug('templates write: ') : noop())
    .pipe(browserSync.stream({once: true}));
}

export function other() {
  return gulp.src( config.modules.templates.src.other, { since: gulp.lastRun('other') } )
    .pipe(config.run.debug ? debug('templates read: ') : noop())
    .pipe(gulp.dest(config.modules.templates.dest.other))
    .pipe(config.run.debug ? debug('templates write: ') : noop())
    .pipe(browserSync.stream({once: true, match: '**/*.{html,php}'}));
}

gulp.task('watch:other', () =>
  gulp.watch([ ...config.modules.templates.src.other, '!../../templates/starlink/gulpfile.*' ], other)
);


gulp.task('watch:css', () =>
  gulp.watch(config.modules.templates.src.css, css)
);

//</editor-fold>




/*

const js = () =>
        gulp.src(config.modules.templates.src.js)
        .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
        .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
        .pipe(config.run.js.uglify ? $.uglify(config.plugin.js.uglify) : $.util.noop())
        .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
        .pipe(gulp.dest(config.modules.templates.dest.js))
        .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());


const images = () =>
        gulp.src(config.modules.templates.src.images)
        .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
        .pipe(config.run.imagemin ? $.imagemin(config.plugin.imagemin) : $.util.noop())
        .pipe(gulp.dest(config.modules.templates.dest.images))
        .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());


const other1 = () =>
        gulp.src(config.modules.templates.src.other)
        .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
        .pipe(gulp.dest(config.modules.templates.dest.other))
        .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());

const other2 = () =>
        gulp.src(config.modules.templates.src.jsBootstrap)
        .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
        .pipe(gulp.dest(config.modules.templates.dest.jsBootstrap))
        .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());

const other = gulp.series(other1, other2);

const zip = () =>
        gulp.src(config.modules.templates.src.zip)
        .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
        .pipe($.zip('starlink.zip'))
        .pipe(gulp.dest(config.modules.templates.dest.zip))
        .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());


const build = gulp.series(gulp.parallel(css, js, images, other), zip);
export default { COMPONENT, build, css, images, js, other, zip }*/






//<editor-fold desc="Tasks: public">



gulp.task('build:default', gulp.series(init, connect, 'watch:other'));
gulp.task('build:incr', gulp.series(init, connect, gulp.parallel('watch:css', 'watch:other')));
gulp.task('default', gulp.series('build:default'));

gulp.task('test', testPatterns);


//</editor-fold>