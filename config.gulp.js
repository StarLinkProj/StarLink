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



const modules = {


  bootstrap: {
    src: {
      sass: ROOTS.bootstrap + '/bootstrap.scss',
      zip:  [ ROOTS.bootstrap + '/css/bootstrap.*', ROOTS.bootstrap + '/js/bootstrap.*' ]
    },
    dest: {
      css: ROOTS.bootstrap + '/css',
      zip: PACKAGES + '/vendors'
    },
    options: {
      includePaths: [
        ROOTS.$include,
        './node_modules/bootstrap-sass/assets/stylesheets'
      ]
    }
  },


  basscss: {
    src:  {
      css: ROOTS.basscss + '/src/base.css',
      zip: ROOTS.basscss + '/css/base.css'
    },
    dest: {
      css: ROOTS.basscss + '/css',
      zip: PACKAGES + '/vendors'
    },
    postcss: [
      require('postcss-import'),
      require('postcss-custom-media'),
      require('postcss-custom-properties'),
      require('postcss-color-function'),
      require('postcss-calc'),
      require('postcss-discard-comments') //,require('autoprefixer')
    ]
  },


  modcalc: {
    src: {
      all:    ROOTS.modcalc + '/**/*.*',
      css:    ROOTS.modcalc + '/css/starlink_calculator_outsourcing.css',
      js:     ROOTS.modcalc + '/js/starlink_calculator_outsourcing.js',
      images: ROOTS.modcalc + '/images/**/*.*',
      other:  [
        ROOTS.modcalc + '/**/*.*',
        '!**/css/*.*',
        '!**/js/*.*',
        '!**/images/**/*.*'
      ],
      zip:    [
        JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/**/*.*',
        JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing/**/*.*'
      ]
    },
    dest : {
      css:    JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/css',
      js:     JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/js',
      images: JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/images',
      other:  JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing',
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
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  },


  modmaps: {
    src: {
      all:    ROOTS.modmaps + '/**/*.*',
      zip:    JOOMLA_MODULES + '/mod_starlink_map/**/*.*'
    },
    dest : {
      all:    JOOMLA_MODULES + '/mod_starlink_map',
      zip:    PACKAGES
    }
  },


  modservices: {
    src: {
      all:    ROOTS.modservices + '/**/*.*',
      css:    ROOTS.modservices + '/css/!(_)*.css',
      images: ROOTS.modservices + '/images/**/*.*',
      js:     '',
      other:  [
        ROOTS.modservices + '/**/*.*',
        '!**/css/*.*',
        '!**/js/*.*',
        '!**/images/**/*.*'
      ],
      zip:    [
        JOOMLA_MEDIA + '/mod_starlink_services/**/*.*',
        JOOMLA_MODULES + '/mod_starlink_services/**/*.*'
      ]
    },
    dest : {
      css:    JOOMLA_MEDIA + '/mod_starlink_services/css',
      images: JOOMLA_MEDIA + '/mod_starlink_services/images',
      js:     '',
      other:  JOOMLA_MODULES + '/mod_starlink_services',
      zip:    PACKAGES
    },
    postcss: [
      require('postcss-import')({path: [SRC_ROOT + '/_includes']}),
      require('postcss-mixins'),
      require('postcss-custom-properties'),
      require('postcss-apply'),
      require('postcss-calc'),
      //require('postcss-nesting'),
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
      //require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  },


  modstarlink: {
    src: {
      all:    ROOTS.modstarlink + '/**/*.*',
      css:    ROOTS.modstarlink + '/css/!(_)*.css',
      js:     ROOTS.modstarlink + '/js/*.js',
      images: ROOTS.modstarlink + '/images/**/*.*',
      vendorCss: [
        ROOTS.bootstrap + '/css/bootstrap.*',    //  = modules.bootstrap.dest.css
        ROOTS.basscss + '/css/base.css'            //  = modules.basscss.dest.css
      ],
      other:  [
        ROOTS.modstarlink + '/**/*.*',
        '!**/css/*.*',
        '!**/js/*.*',
        '!**/images/**/*.*'
      ],
      zip:    [
        JOOMLA_MEDIA + '/mod_starlink/**/*.*',
        JOOMLA_MODULES + '/mod_starlink/**/*.*'
      ]
    },
    dest: {
      css:    JOOMLA_MEDIA + '/mod_starlink/css',
      js:     JOOMLA_MEDIA + '/mod_starlink/js',
      images: JOOMLA_MEDIA + '/mod_starlink/images',
      other:  JOOMLA_MODULES + '/mod_starlink',
      zip:    PACKAGES
    },
    postcss: [
      require('postcss-import')({path: [ ROOTS.$include
          /*, ROOTS.basscss + '/css', ROOTS.template + '/css', ROOTS.modcalc + '/css'*/
      ]}),
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
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  },


  templates: {
    src: {
      all:    ROOTS.template + '/**/*.*',
      css:    ROOTS.template + '/css/!(_)*.css',
      js:     ROOTS.template + '/js/*.js',
      jsBootstrap: ROOTS.bootstrap + '/js/*.js',
      images: ROOTS.template + '/images/**/*.*',
      other:   [
        ROOTS.template + '/**/*.*',
        '!**/css/*.*',
        '!**/js/*.*',
        '!**/images/**/*.*'
      ],
      zip:    JOOMLA_TEMPLATES + '/starlink/**/*.*'
    },
    dest: {
      css:    JOOMLA_TEMPLATES + '/starlink/css',
      js:     JOOMLA_TEMPLATES + '/starlink/js',
      jsBootstrap:     JOOMLA_TEMPLATES + '/starlink/js/jui',
      images: JOOMLA_TEMPLATES + '/starlink/images',
      other:  JOOMLA_TEMPLATES + '/starlink/',
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
      require('postcss-color-function'), /*require('pixrem'),*/
      require('postcss-url'),
      require('postcss-for'),
      require('postcss-discard-comments'),
      require('autoprefixer')({'browsers': '> 1%'}),
      require('css-mqpacker')({sort: true})
    ]
  }

};

const sources = [
/*        [ "modcalc",  {
            src: {
              all:      ROOTS.modcalc + '/!**!/!*.*',
              css:      ROOTS.modcalc + '/css/starlink_calculator_outsourcing.css',
              js:       ROOTS.modcalc + '/js/starlink_calculator_outsourcing.js',
              images:   ROOTS.modcalc + '/images/!**!/!*.*',
              other:  [
                        ROOTS.modcalc + '/!**!/!*.*',
                  '!' + ROOTS.modcalc + '**!/css/!*.*',
                  '!' + ROOTS.modcalc + '**!/js/!*.*',
                  '!' + ROOTS.modcalc + '**!/images/!**!/!*.*'
              ],
              zip:    [
                JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/!**!/!*.*',
                JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing/!**!/!*.*'
              ]
            },
            dest: {
              css:    JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/css',
              js:     JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/js',
              images: JOOMLA_MEDIA + '/mod_starlink_calculator_outsourcing/images',
              other:  JOOMLA_MODULES + '/mod_starlink_calculator_outsourcing',
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
              require('autoprefixer')({'browsers': '> 1%'}),
              require('css-mqpacker')({sort: true})
            ]
            }
        ],*/
        [ "templates", {
            src: {
              _base:        ROOTS.templates,
    /**/      css: [
                            ROOTS.templates + '/**/!(_)*.css',
                      '!' + ROOTS.templates + '/**/bootstrap.css',
              ],
              js: [         ROOTS.templates + '/**/*.js',
                      '!' + ROOTS.templates + '/**/gulp*.js'
              ],
              markup:       ROOTS.templates + '/**/*.{html,php}',
              images:       ROOTS.templates + '/**/*.{jpg,jpeg,png,svg,gif}',
              other:        ROOTS.templates + '/**/*.{xml,ini,txt,MD}',
              zip:          ROOTS.templates + '/**/*.*'
            },
            dest: {
              _base:        JOOMLA_TEMPLATES,
              css:          JOOMLA_TEMPLATES,
              js:           JOOMLA_TEMPLATES,
              jsBootstrap:  JOOMLA_TEMPLATES + '/starlink/js/jui',
              images:       JOOMLA_TEMPLATES,
              other:        JOOMLA_TEMPLATES,
              zip:          PACKAGES
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
               /*require('pixrem'),*/
              require('postcss-url'),
              require('postcss-for'),
              require('postcss-discard-comments'),
              require('autoprefixer')({'browsers': '> 1%'}),
              require('css-mqpacker')({sort: true})
            ]
          }
        ],
        [ "modules", {
            src: {
              _base:        ROOTS.modules,
              css:          ROOTS.modules + '/mod_starlink*/**/!(_)*.css',
              images:       ROOTS.modules + '/mod_starlink*/**/*.{jpg,jpeg,png,svg,gif}',
              js:           ROOTS.modules + '/mod_starlink*/**/*.js',
              markup:       ROOTS.modules + '/mod_starlink*/**/*.{html,php}',
              other:        ROOTS.modules + '/mod_starlink*/**/*.{xml,ini,txt,MD}',
              zip:          ROOTS.modules + '/mod_starlink*/../starlink/**/*.*'
            },
            dest: {
              /*_base:        JOOMLA_MODULES,*/
              css:          JOOMLA_MEDIA,
              images:       JOOMLA_MEDIA,
              js:           JOOMLA_MEDIA,
              markup:       JOOMLA_MODULES,
              other:        JOOMLA_MODULES,
              zip:          PACKAGES
            },
            postcss: [
              require('postcss-import')({path: [
                ROOTS.$include,
                ROOTS.basscss + '/css',
                ROOTS.template + '/css',
                ROOTS.modcalc + '/css'
              ]}),
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
              require('autoprefixer')({'browsers': '> 1%'}),
              require('css-mqpacker')({sort: true})
            ]
          }
        ],
        [
          "vendors", {
            src:  {
              /*_base:        ROOTS.vendors,*/
              css: [        ROOTS.basscss + '/src/base.css',
                ROOTS.bootstrap + '/bootstrap.scss'
              ],
              js:  [        ROOTS.bootstrap + '/js/*.js' ],
              markup:       null,
              images:       null,
              other:        null,
              zip: [        JOOMLA_MEDIA + '/mod_starlink/{css,js}/vendors'
              ]
            },
            dest: {
              /*_base:        ROOTS.vendors,*/
              css:          JOOMLA_MEDIA + '/mod_starlink/css/vendors',
              js:           JOOMLA_TEMPLATES + '/starlink/js/jui',  //JOOMLA_MEDIA + '/mod_starlink/js/vendors',
              markup:       null,
              images:       null,
              other:        null,
              zip:          PACKAGES + '/vendors'
            },
            postcss: [
              require('postcss-import'),
              require('postcss-custom-media'),
              require('postcss-custom-properties'),
              require('postcss-color-function'),
              require('postcss-calc'),
              /*require('postcss-color-function'),*/
              require('postcss-discard-comments'),//require('autoprefixer')
            ]
          }
        ],
        ["basscss",
          {
            src:     {
              css: ROOTS.basscss + '/src/base.css'
            },
            dest:    {
              css: ROOTS.basscss + '/css'
            },
            postcss: [
              require('postcss-import'),
              require('postcss-custom-media'),
              require('postcss-custom-properties'),
              require('postcss-color-function'),
              require('postcss-calc'),
              /*require('postcss-color-function'),*/
              require('postcss-discard-comments'),
              require('cssnano'),
              require('postcss-prettify')//,require('autoprefixer')
            ]
          }
        ],
        ["bootstrap",
          {
            src:  {
              sass: ROOTS.bootstrap + '/bootstrap.scss',
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
          }
        ],
];


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
      autoprefixer: false
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
const plugins = {
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
      require('gulp-imagemin').gifsicle,
      require('gulp-imagemin').jpegtran,
      require('gulp-imagemin').optipng
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
    },
    imagemin: null
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


//</editor-fold>



      /*gutil.log(APP_ROOT);*/

exports.SRC_ROOT = SRC_ROOT;

exports.sources = new Map(sources);
      /*gutil.log(exports.sources);
      gutil.log(exports.sources.get('modcalc'));*/

exports.env = gutil.env.env || 'development';
      /*gutil.log(`env=${exports.env}`);*/
      /*gutil.log(`${stringly(plugins[exports.env])}`);
      gutil.log(`${stringly(plugins.default)}`);
      gutil.log(`${stringly(plugins[exports.env] || plugins.default)}`);*/

exports.constants = _merge({}, constants.default, constants[exports.env] || constants.default);
exports.plugins = _merge({}, plugins.default, plugins[exports.env] || plugins.default);
exports.run = _merge({}, run.default, run[exports.env] || run.default);

if (exports.plugins.browserSync.server === null)
  delete exports.plugins.browserSync.server;
if (exports.plugins.browserSync.proxy === null)
  delete exports.plugins.browserSync.proxy;


//export default { mainConfig, modules, constants, run, plugin, env }