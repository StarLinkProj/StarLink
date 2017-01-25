'use strict';

const gutil = require('gulp-util');
const _merge = require('lodash.merge');
const stringly = require('./.gulp/helpers').stringly;

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
let path_prefix = (gutil.env.abs ? APP_ROOT : '.' );

/* Change to safe folder if you fear to overwrite something */
const DEBUG_PREFIX = '';
path_prefix += DEBUG_PREFIX;

const SRC_ROOT = path_prefix + '/.src';

const ENTITIES = new Map( [
  [ 'modCalc', {
      name: 'modCalc',
      path: 'mod_starlink_calculator_outsourcing',
      type: 'module'
  }],
  [ 'modServices', {
      name: 'modServices',
      path: 'mod_starlink_services',
      type: 'module'
  }],
  [ 'modStarlink', {
      name: 'modStarlink',
      path: 'mod_starlink',
      type: 'module'
  }],
  [ 'modMap', {
      name: 'modMap',
      path: 'mod_starlink_map',
      type: 'module'
  }],
  [ 'templateStarlink', {
      name: 'templateStarlink',
      path: 'starlink',
      type: 'template'
  }],
  [ 'basscss', {
      name: 'basscss',
      path: 'basscss',
      type: 'vendor'
  }],
  [ 'bootstrap', {
      name: 'bootstrap',
      path: 'bootstrap',
      type: 'vendor'
  }]
] );
//ENTITIES.forEach( e => {console.log(stringly(e))});

const entities = {
  modcalc:          'mod_starlink_calculator_outsourcing',
  modmaps:          'mod_starlink_map',
  modservices:      'mod_starlink_services',
  modstarlink:      'mod_starlink',
  templateStarlink: 'starlink'
};

const ROOTS = {
  $include:     SRC_ROOT + '/_includes',
  modules:      SRC_ROOT,
  modcalc:      SRC_ROOT + '/' + entities.modcalc,
  modmaps:      SRC_ROOT + '/' + entities.modmaps,
  modservices:  SRC_ROOT + '/' + entities.modservices,
  modstarlink:  SRC_ROOT + '/' + entities.modstarlink,
  templates:    SRC_ROOT + '/templates',
  template:     SRC_ROOT + '/templates' + '/' + entities.templateStarlink,
  vendors:      SRC_ROOT + '/vendor',
  bootstrap:    SRC_ROOT + '/vendor/bootstrap',
  basscss:      SRC_ROOT + '/vendor/basscss'
};

const JOOMLA_MEDIA = path_prefix + '/media';
const JOOMLA_MODULES = path_prefix + '/modules';
const PACKAGES = path_prefix + '/.dist';
const JOOMLA_TEMPLATES = path_prefix + '/templates';

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
  [ 'template', {
    src: {
      css:          ROOTS.template + '/**/*.css',
      js:           ROOTS.template + '/**/*.js',
      jsBootstrap:  ROOTS.bootstrap + '/js/*.js',
      images:       ROOTS.template + '/**/*.{jpg,jpeg,png,svg,gif}',
      markup:       ROOTS.template + '/**/*.{html,php}',
      other:        ROOTS.template + '/**/*.{xml,ini,txt,MD,ico}',
      zip:          JOOMLA_TEMPLATES + '/starlink/**/*.*',
      clean:        JOOMLA_TEMPLATES + '/starlink/**'
    },
    dest: {
      css:          JOOMLA_TEMPLATES + '/starlink',
      js:           JOOMLA_TEMPLATES + '/starlink',
      jsBootstrap:  JOOMLA_TEMPLATES + '/starlink/js/jui',
      images:       JOOMLA_TEMPLATES + '/starlink',
      markup:       JOOMLA_TEMPLATES + '/starlink',
      other:        JOOMLA_TEMPLATES + '/starlink',
      zipName:      'template_starlink',
      zip:          PACKAGES
    },
    postcss: [
      require('postcss-import')({
        path: [ ROOTS.$include,
                ROOTS.basscss + '/css',
        ]
      }),
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
      require('cssnano'),
      require('postcss-prettify'),
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  } ],
  [ 'modstarlink', {
    src: {
      css:    ROOTS.modstarlink + '/**/!(_)*.css',
      cssAll: ROOTS.modstarlink + '/**/*.css',
      js:     ROOTS.modstarlink + '/**/*.js',
      images: ROOTS.modstarlink + '/**/*.{jpg,jpeg,png,gif}',
      fonts:  ROOTS.modstarlink + '/**/*.{eot,ttf,woff,woff2}',
      svgs:   ROOTS.modstarlink + '/**/*.svg',
      other:  ROOTS.modstarlink + '/**/*.{html,php,xml,ini,txt,MD,ico}',
      vendorCss: [
        ROOTS.bootstrap + '/css/*.*',
        ROOTS.basscss + '/css/*.*'
      ],
      zip:    [
        JOOMLA_MEDIA + '/mod_starlink/**/*.*',
        JOOMLA_MODULES + '/mod_starlink/**/*.*'
      ],
      clean: [
        JOOMLA_MODULES + '/mod_starlink/**',
        JOOMLA_MEDIA + '/mod_starlink/**'
      ]
    },
    dest: {
      css:        JOOMLA_MEDIA + '/mod_starlink',
      vendorCss:  JOOMLA_MEDIA + '/mod_starlink/css',
      js:         JOOMLA_MEDIA + '/mod_starlink',
      images:     JOOMLA_MEDIA + '/mod_starlink',
      other:      JOOMLA_MODULES + '/mod_starlink',
      zipName:    'mod_starlink',
      zip:        PACKAGES
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
      require('postcss-calc')({precision: 10}),
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
      other:  ROOTS.modcalc + '/**/*.{html,php,xml,ini,txt,MD,ico}',
      zip:    [
        JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/**/*.*',
        JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing/**/*.*'
      ],
      clean: [
        JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing/**',
        JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/**'
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
      require('postcss-calc')({precision: 10}),
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
        JOOMLA_MODULES + '/mod_starlink_map/**',
        JOOMLA_MEDIA + '/mod_starlink_map/**'
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
      other:  ROOTS.modservices + '/**/*.{html,php,xml,ini,txt,MD,ico}',
      zip: [
        JOOMLA_MEDIA + '/mod_starlink_services/**/*.*',
        JOOMLA_MODULES + '/mod_starlink_services/**/*.*'
      ],
      clean: [
        JOOMLA_MODULES + '/mod_starlink_services/**',
        JOOMLA_MEDIA + '/mod_starlink_services/**'
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
      require('postcss-calc')({precision: 10}),
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
      clean: ROOTS.basscss + '/css/base.*'
    },
    dest:    {
      css: ROOTS.basscss + '/css'
    },
    postcss: [
      require('postcss-import')({
        path: [ ROOTS.$include ]
      }),
      require('postcss-custom-media'),
      require('postcss-custom-properties'),
      require('postcss-simple-vars'),
      require('postcss-color-function'),
      require('postcss-calc')({precision: 10}),
/*    require('postcss-color-function'), */
      require('postcss-discard-comments'),
      require('cssnano'),
      require('postcss-prettify')
/*   ,require('autoprefixer') */
    ]
  } ],
  [ 'bootstrap', {
    src:  {
      sass: ROOTS.bootstrap + '/bootstrap.scss',
      js: ROOTS.bootstrap + '/js/bootstrap.js',
      clean: [ ROOTS.bootstrap + '/css/bootstrap.*', ROOTS.bootstrap + '/js/bootstrap.min.js' ]
    },
    dest: {
      css: ROOTS.bootstrap + '/css',
      js: ROOTS.bootstrap + '/js'
    },
    options: {
      includePaths: [
        ROOTS.$include,
        './node_modules/bootstrap-sass/assets/stylesheets'
      ]
    },
    postcss: [
      require('postcss-custom-properties'),
      require('postcss-prettify')
    ]
  } ]
]);