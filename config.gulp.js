import gutil from 'gulp-util';
import merge from 'lodash.merge';



//<editor-fold desc="Constants">
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



const SRC_ROOT = './.src';
const ROOTS = {
  $include:    SRC_ROOT + '/_includes',
  bootstrap:   SRC_ROOT + '/bootstrap',
  basscss:     SRC_ROOT + '/bassplate2',
  modcalc:     SRC_ROOT + '/mod_starlink_calculator_outsourcing',
  modmaps:     SRC_ROOT + '/mod_starlink_map',
  modservices: SRC_ROOT + '/mod_starlink_services',
  modstarlink: SRC_ROOT + '/modstarlink',
  template:    SRC_ROOT + '/templates/starlink'
};
const JOOMLA_MEDIA = './media';
const JOOMLA_MODULES = './modules';
const PACKAGES = './.dist';
const JOOMLA_TEMPLATES = './templates';
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
      require('postcss-calc'),
      require('postcss-color-function'),
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






const env = gutil.env.env || 'development';

run = merge( {}, run.default, run[ env ] );
constants = merge( {}, constants.default, constants[ env ] );
plugin = merge( {}, plugin.default, plugin[ env ] );

  if (plugin.browserSync.server === null)
    delete plugin.browserSync.server;
  if (plugin.browserSync.proxy === null)
    delete plugin.browserSync.proxy;
//</editor-fold>



export default { modules, constants, run, plugin, env }

