'use strict';

const gutil = require('gulp-util');
const _merge = require('lodash.merge');
const stringly = require('./.gulp/stringly');

//<editor-fold desc="Module description">

/* use particular environment:
 *
 *      gulp build --env=production
 *
 *
 *
 *
 * use config objects in tasks in main gulpfile.js:
 *
 *      import gulp from 'gulp'),
 *      uglify = require('gulp-uglify'),
 *      gutil = require('gulp-util'),
 *      config = require('./config');
 *
 *      gulp.task('js', () =>
 *              gulp.src(config.paths.src.js)
 *                .pipe(config.run.js.uglify ? uglify(config.plugin.js.uglify) : gutil.noop())
 *                .pipe(gulp.dest(config.paths.dest.js))
 *      );
 *
 */

//</editor-fold>


//<editor-fold desc="Constants">



/* run with --abs -> convert all paths to absolute */
const path_prefix = (gutil.env.abs ? APP_ROOT : '.' );
const SRC_ROOT = path_prefix + '/.src';
const ROOTS = {
  $include:     SRC_ROOT + '/_includes',
  modules:      SRC_ROOT,
  templates:    SRC_ROOT + '/templates',
  template:     SRC_ROOT + '/templates/starlink/',
  vendors:      SRC_ROOT + '/vendor',
  bootstrap:    SRC_ROOT + '/vendor/bootstrap',
  basscss:      SRC_ROOT + '/vendor/basscss',
  modcalc:      SRC_ROOT + '/mod_starlink_calculator_outsourcing',
  modmaps:      SRC_ROOT + '/mod_starlink_map',
  modservices:  SRC_ROOT + '/mod_starlink_services',
  modstarlink:  SRC_ROOT + '/mod_starlink'
};
const JOOMLA_MEDIA = path_prefix + '/tmp' + '/media';
const JOOMLA_MODULES = path_prefix + '/tmp' + '/modules';
const PACKAGES = path_prefix + '/tmp' + '/.dist';
const JOOMLA_TEMPLATES = path_prefix + '/tmp' + '/templates';

//</editor-fold>


//<editor-fold desc="Settings & Initialization routine">


/* Application constants: database names, server addresses etc. */
const constants = {
  default:     {
    apiHost: ''
  },
  development: {
    apiHost: 'http://localhost:8000'
  },
  staging:     {
/*    apiHost: 'http://staging.example.com/api/'*/
  },
  production:  {
/*    apiHost: 'http://example.com/api/'*/
  }
};


/* Object for toggling plugins on/off depending on environment */
const run = {
  default:     {
    debug: true,
    sourcemaps: true,
    imagemin: false,
    uglify: false,
    zip: true,
    js:  {
      sourcemaps: false
    },
    css: {
      cssnano: false,
      autoprefixer: false
    }
  },
  development: {
    debug: true,
    sourcemaps: true,
    uglify: false,
    js:  {
      sourcemaps: false
    },
    css: {
      cssnano: false,
      autoprefixer: false
    }
  },
  staging:     {
    sourcemaps: true,
    uglify: true,
    js:  {
      sourcemaps:true
    },
    css: {
      cssnano: true,
      autoprefixer: false
    }
  },
  production:  {
    sourcemaps: false,
    uglify: true,
    js:  {
      sourcemaps: false
    },
    css: {
      cssnano: true,
      autoprefixer: true
    }
  }
};


/* Plugin options depending on environment */
const plugins = {
  default:     {
    js: {   },
    uglify: {
      mangle: true
    },
    browserSync: {
      server: '.',
      browser: ['chrome']
    },
    imagemin: [
      require('gulp-imagemin').gifsicle,
      require('gulp-imagemin').jpegtran,
      require('gulp-imagemin').optipng
    ]
  },
  development: {
    js: { },
    uglify: {
      mangle: false
    },
    browserSync: {
      server: null,
      proxy: 'localhost:8000'
    },
    imagemin: null
  },
  staging:     {
    js: {   },
    uglify: {
      mangle: true
    }
  },
  production:  {
    js: { },
    uglify: {
      mangle: true
    }
  }
};


//</editor-fold>

exports.SRC_ROOT = SRC_ROOT;
exports.env = gutil.env.env || 'development';

exports.constants = _merge({}, constants.default, constants[exports.env] || constants.default);
exports.plugins = _merge({}, plugins.default, plugins[exports.env] || plugins.default);
exports.run = _merge({}, run.default, run[exports.env] || run.default);

if (exports.plugins.browserSync.server === null)
  delete exports.plugins.browserSync.server;
if (exports.plugins.browserSync.proxy === null)
  delete exports.plugins.browserSync.proxy;

exports.sources = new Map([
  [ 'templates', {
    src: {
      /*_base:        ROOTS.templates,*/
      css:          ROOTS.templates + '/**/!(_)*.css',
      js:           ROOTS.templates + '/**/*.js',
      jsBootstrap:  ROOTS.bootstrap + '/js/bootstrap.js',
      images:       ROOTS.templates + '/**/*.{jpg,jpeg,png,svg,gif}',
      markup:       ROOTS.templates + '/**/*.{html,php}',
      other:        ROOTS.templates + '/**/*.{xml,ini,txt,MD}'
    },
    dest: {
      /* _base:        JOOMLA_TEMPLATES,*/
      css:          JOOMLA_TEMPLATES,
      js:           JOOMLA_TEMPLATES,
      jsBootstrap:  JOOMLA_TEMPLATES + '/starlink/js/jui',
      images:       JOOMLA_TEMPLATES,
      markup:       JOOMLA_TEMPLATES,
      other:        JOOMLA_TEMPLATES
    },
    postcss: [
      require('postcss-import')({path: [SRC_ROOT + '/_includes']}),
      require('postcss-mixins'),
      require('postcss-custom-properties'),
      require('postcss-simple-vars'),
      require('postcss-apply'),
      require('postcss-calc'),
      require('postcss-nesting'),
      require('postcss-custom-media'),
      require('postcss-extend'),
      require('postcss-media-minmax'),
      require('postcss-custom-selectors'),
      require('postcss-color-function'),
      require('postcss-color-hwb'),
      require('postcss-color-gray'),
      require('postcss-color-hex-alpha'),
      /*require('pixrem'),*/
      require('postcss-url'),
      require('postcss-for'),
      require('postcss-discard-comments'),
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  } ],
  [ 'template', {
    src: {
      css:          ROOTS.template + '/**/!(_)*.css',
      js:           ROOTS.template + '/**/*.js',
      jsBootstrap:  ROOTS.bootstrap + '/js/bootstrap.js',
      images:       ROOTS.template + '/**/*.{jpg,jpeg,png,svg,gif}',
      markup:       ROOTS.template + '/**/*.{html,php}',
      other:        ROOTS.template + '/**/*.{xml,ini,txt,MD}',
      zip:          JOOMLA_TEMPLATES + '/starlink/**/*.*',
      clean:        JOOMLA_TEMPLATES + '/starlink'
    },
    dest: {
      css:          JOOMLA_TEMPLATES + '/starlink',
      js:           JOOMLA_TEMPLATES + '/starlink',
      jsBootstrap:  JOOMLA_TEMPLATES + '/starlink/js/jui',
      images:       JOOMLA_TEMPLATES + '/starlink',
      markup:       JOOMLA_TEMPLATES + '/starlink',
      other:        JOOMLA_TEMPLATES + '/starlink',
      zipName:      'starlink',
      zip:          PACKAGES
    },
    postcss: [
      require('postcss-import')({path: [SRC_ROOT + '/_includes']}),
      require('postcss-mixins'),
      require('postcss-custom-properties'),
      require('postcss-simple-vars'),
      require('postcss-apply'),
      require('postcss-calc'),
      require('postcss-nesting'),
      require('postcss-custom-media'),
      require('postcss-extend'),
      require('postcss-media-minmax'),
      require('postcss-custom-selectors'),
      require('postcss-color-function'),
      require('postcss-color-hwb'),
      require('postcss-color-gray'),
      require('postcss-color-hex-alpha'),
      /*require('pixrem'),*/
      require('postcss-url'),
      require('postcss-for'),
      require('postcss-discard-comments'),
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  } ],
  [ 'modstarlink', {
    src: {
      css:    ROOTS.modstarlink + '/**/!(_)*.css',
      js:     ROOTS.modstarlink + '/**/*.js',
      images: [
        ROOTS.modstarlink + '/**/*.{jpg,jpeg,png,svg,gif}',
        '!' + ROOTS.modstarlink + '/fonts/**/*.*'
      ],
      fonts:  ROOTS.modstarlink + '/**/fonts/*.{eot,svg,ttf,woff,woff2}',
      other:  ROOTS.modstarlink + '/**/*.{html,php,xml,ini,txt,MD}',
      vendorCss: [
        ROOTS.bootstrap + '/css/*.*',
        ROOTS.basscss + '/css/*.*'
      ],
      zip:    [
        JOOMLA_MEDIA + '/mod_starlink/**/*.*',
        JOOMLA_MODULES + '/mod_starlink/**/*.*'
      ],
      clean: [
        JOOMLA_MODULES + '/mod_starlink',
        JOOMLA_MEDIA + '/mod_starlink'
      ]
    },
    dest: {
      css:    JOOMLA_MEDIA + '/mod_starlink',
      vendorCss: JOOMLA_MEDIA + '/mod_starlink/css',
      js:     JOOMLA_MEDIA + '/mod_starlink',
      images: JOOMLA_MEDIA + '/mod_starlink',
      other:  JOOMLA_MODULES + '/mod_starlink',
      zipName:'mod_starlink',
      zip:    PACKAGES
    },
    postcss: [
      require('postcss-import')({
        path: [
          ROOTS.$include,
          ROOTS.basscss + '/css',
          ROOTS.templates + '/starlink/css',
          ROOTS.modcalc + '/css'
        ]
      }),
      require('postcss-mixins'),
      require('postcss-simple-vars'),
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
      require('cssnano'),
      require('postcss-prettify'),
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  } ],
  [ 'modcalc', {
    src: {
      css:    ROOTS.modcalc + '/**/!(_)*.css',
      js:     ROOTS.modcalc + '/**/*.js',
      images: ROOTS.modcalc + '/**/*.{jpg,jpeg,png,svg,gif}',
      other:  ROOTS.modcalc + '/**/*.{html,php,xml,ini,txt,MD}',
      zip:    [
        JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/**/*.*',
        JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing/**/*.*'
      ],
      clean: [
        JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing/**/*.*',
        JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/**/*.*'
      ]
    },
    dest: {
      css:    JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing',
      js:     JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing',
      images: JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing',
      other:  JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing',
      zipName:'mod_starlink_calculator_outsourcing',
      zip:    PACKAGES
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
      require('postcss-color-function'),
      //require('pixrem'),
      require('postcss-url'),
      require('postcss-for'),
      require('postcss-discard-comments'),
      require('cssnano'),
      require('postcss-prettify'),
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  } ],
  [ 'modmap', {
    src: {
      all:    ROOTS.modmaps + '/**/*.*',
      zip:    JOOMLA_MODULES + '/mod_starlink_map/**/*.*',
      clean: [
        JOOMLA_MODULES + '/mod_starlink_map/**/*.*',
        JOOMLA_MEDIA + '/mod_starlink_map/**/*.*'
      ]
    },
    dest: {
      all:    JOOMLA_MODULES + '/mod_starlink_map',
      zipName:'mod_starlink_map',
      zip:    PACKAGES
    }
  } ],
  [ 'modservices', {
    src: {
      css:    ROOTS.modservices + '/**/!(_)*.css',
      images: ROOTS.modservices + '/**/*.{jpg,jpeg,png,svg,gif}',
      other:  ROOTS.modservices + '/**/*.{html,php,xml,ini,txt,MD}',
      zip: [
        JOOMLA_MEDIA + '/mod_starlink_services/**/*.*',
        JOOMLA_MODULES + '/mod_starlink_services/**/*.*'
      ],
      clean: [
        JOOMLA_MODULES + '/mod_starlink_services/**/*.*',
        JOOMLA_MEDIA + '/mod_starlink_services/**/*.*'
      ]
    },
    dest: {
      css:    JOOMLA_MEDIA + '/mod_starlink_services',
      images: JOOMLA_MEDIA + '/mod_starlink_services',
      other:  JOOMLA_MODULES + '/mod_starlink_services',
      zipName:'mod_starlink_services',
      zip:    PACKAGES
    },
    postcss: [
      require('postcss-import')({path: [SRC_ROOT + '/_includes']}),
      //require('postcss-mixins'),
      require('postcss-custom-properties'),
      require('postcss-simple-vars'),
      //require('postcss-apply'),
      require('postcss-calc'),
      //require('postcss-nesting'),
      //require('postcss-custom-media'),
      //require('postcss-extend'),
      require('postcss-media-minmax'),
      //require('postcss-custom-selectors'),
      //require('postcss-color-hwb'),
      //require('postcss-color-gray'),
      //require('postcss-color-hex-alpha'),
      //require('postcss-color-function'),
      //require('pixrem'),
      require('postcss-url'),
      //require('postcss-for'),
      require('postcss-discard-comments'),
      //require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  } ],
  [ 'basscss', {
    src:     {
      css: ROOTS.basscss + '/src/base.css',
      clean: ROOTS.basscss + '/css/base.css'
    },
    dest:    {
      css: ROOTS.basscss + '/css'
    },
    postcss: [
      require('postcss-import'),
      require('postcss-custom-media'),
      require('postcss-custom-properties'),
      require('postcss-simple-vars'),
      require('postcss-color-function'),
      require('postcss-calc'),
      /*require('postcss-color-function'),*/
      require('postcss-discard-comments'),
      require('cssnano'),
      require('postcss-prettify')//,require('autoprefixer')
    ]
  } ],
  [ 'bootstrap', {
    src:  {
      sass: ROOTS.bootstrap + '/bootstrap.scss',
      clean: ROOTS.bootstrap + '/css/bootstrap.*'
    },
    dest: {
      css: ROOTS.bootstrap + '/css'
    },
    options: {
      includePaths: [
        ROOTS.$include,
        './node_modules/bootstrap-sass/assets/stylesheets'
      ]
    },
    postcss: [
      require('postcss-prettify')
    ]
  } ],
]);