'use strict';

import gulp from 'gulp';
const $ = require('gulp-load-plugins')();
const browserSync = require('browser-sync').create();
const reload = browserSync.reload;

import stringly from '../../../.gulp/stringly';

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
  template:    SRC_ROOT + '/templates/starlink'
};
const JOOMLA_MEDIA = PROJ_ROOT + '/media';
const JOOMLA_MODULES = PROJ_ROOT + '/modules';
const PACKAGES = PROJ_ROOT + '/.dist';
const JOOMLA_TEMPLATES = PROJ_ROOT + '/templates';



//<editor-fold desc="Settings & Initialization routine">

const config = {
  modules: {
    templates: {
      src:     {
        all:         ROOTS.template + '/**/*.*',
        css:         ROOTS.template + '/css/!(_)*.css',
        js:          ROOTS.template + '/js/*.js',
        jsBootstrap: ROOTS.bootstrap + '/js/*.js',
        images:      ROOTS.template + '/images/**/*.*',
        other:       [
          ROOTS.template + '/**/*.*',
          '!**/css/*.*',
          '!**/js/*.*',
          '!**/images/**/*.*'
        ],
        zip:         JOOMLA_TEMPLATES + '/starlink/**/*.*'
      },
      dest:    {
        css:         JOOMLA_TEMPLATES + '/starlink/css',
        js:          JOOMLA_TEMPLATES + '/starlink/js',
        jsBootstrap: JOOMLA_TEMPLATES + '/starlink/js/jui',
        images:      JOOMLA_TEMPLATES + '/starlink/images',
        other:       JOOMLA_TEMPLATES + '/starlink/',
        zip:         PACKAGES
      },
      postcss: [
        require('postcss-import')({path: [SRC_ROOT + '/_includes']}),
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
  }
};

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


/* Plugin options depending on environment */
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

  done();
};

//</editor-fold>


const css = () =>
    gulp.src(config.modules.templates.src.css)
    .pipe(config.run.sourcemaps ? $.sourcemaps.init() : $.util.noop())
    .pipe($.postcss(config.modules.templates.postcss))
    .pipe(config.run.sourcemaps ? $.sourcemaps.write('.') : $.util.noop())
    .pipe(config.run.debug ? $.debug({title: 'templates: read: '}) : $.util.noop())
    .pipe(gulp.dest(config.modules.templates.dest.css))
    .pipe(config.run.debug ? $.debug({title: 'templates: write: '}) : $.util.noop());
    .pipe(browserSync.stream({match: '**/*.css'}));


gulp.task('connect', function() {
  browserSync.init(plugin.browserSync);
});

gulp.task('watch', function() {
  gulp.watch(config.modules.templates.src.css)
    .on('change', css);
  gulp.watch(config.modules.templates.src.other)
    .on('change', reload);
});

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

gulp.task('default', gulp.series(init, 'connect', 'watch'));