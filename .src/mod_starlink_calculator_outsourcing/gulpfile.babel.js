'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();
import {create} from 'browser-sync';

const browser = create();

const CodePaths = {
  modules: {
    mod_calc: {
      src:  './.src/mod_starlink_calculator_outsourcing',
      dest: {
        code: './modules/mod_starlink_calculator_outsourcing',
        assets: './media/mod_starlink_calculator_outsourcing'
      }
    }
  },
  postcss: {
    basscss: {
      src:   './.src/bassplate/src/base.css',
      dest:  './media/mod_starlink/css'
    },
    mod_starlink: {
      src:  [ './.src/mod_starlink/css/!(_)*.css', '!(bootstrap)*.css' ],
      dest:  './media/mod_starlink/css'
    },
    mod_services: {
      src:   './.src/mod_starlink_services/css/!(_)*.css',
      dest:  './media/mod_starlink_services/css'
    },
    mod_calc: {
      src:   './.src/mod_starlink_calculator_outsourcing/css/!(_)*.css',
      dest:  './media/mod_starlink_calculator_outsourcing/css'
    },
    templates: {
      src:   './.src/templates/*/css/!(_)*.css',
      dest:  './templates'
    }
  },
  css: {
    src: ['./.src/mod_starlink*/**/bootstrap*.css', './.src/mod_starlink_calculator_*/**/*.css' ],
    dest: './media/'
  },
  js: {
    src:  './.src/mod_starlink*/**/js/*',
    dest: './media'
  },
  images: {
    src:  './.src/mod_starlink*/**/images/**/*',
    dest: './media'
  },
  fonts: {
    src:  './.src/mod_starlink*/**/fonts/*',
    dest: './media'
  },
  code: {
    src: [ './.src/mod_starlink*/**/*.+(php|xml|html)' ],
    dest:  './modules/'
  },
  other: {
    src: [
      './.src/mod_starlink*/*',
      './.src/mod_starlink*/!(css|fonts|images|js|media)/**/*'
    ],
    dest: './.media'
  }
};

const moin = {
  css: {
    src:  CodePaths.modules.mod_calc.src + '/css',
    dest: CodePaths.modules.mod_calc.dest.assets + '/css'
  },
  js: {
    src:  CodePaths.modules.mod_calc.src + '/js',
    dest: CodePaths.modules.mod_calc.dest.assets + '/js'
  },
  images: {
    src:  CodePaths.modules.mod_calc.src + '/images',
    dest: CodePaths.modules.mod_calc.dest.assets + '/images'
  }
};

const postCSSplugins = [
  require('postcss-import')({path: [".src/_includes"]}),
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
];

export const serve = () => {
  browser.init({
    proxy: "localhost:8000",
    browser: ["chrome"]
  });
  //gulp.watch([...CodePaths.postcss.mod_starlink.src,  ...CodePaths.postcss.mod_services.src, ...CodePaths.postcss.templates.src], postcss_cycle);
  gulp.watch(CodePaths.postcss.mod_calc.src, modcalc_cycle);
};

const modcalc_cycle = () => {
  gulp.series('build', browser.reload());
};

gulp.task('build',
        ()=>gulp.src(CodePaths.modules.mod_calc.src)
        .pipe($.postcss(postCSSplugins))
        .pipe($.if(DEBUG, $.debug({title: 'mod_calc: '})))
        .pipe(gulp.dest(CodePaths.postcss.mod_calc.dest))
);