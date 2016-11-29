'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();
import yargs    from 'yargs';
import rimraf   from 'rimraf';
import {create as bcCreate} from 'browser-sync';
const browser = bcCreate();

const PRODUCTION = !!(yargs.argv.production);   // Look for the --production flag in command line

const cleanBuild = done => rimraf("./.build", done);
/*gulp.task('build:clean', cleanBuild);

gulp.task('build',
  gulp.series(
    'build:clean',
    gulp.parallel(
      'postcss',
      'images',
      'fonts',
      'javascript',
      'other'
    )
  )
);*/

const DEBUG = true;


const CodePaths = {
  postcss: {
    basscss: {
      src:   './.src/bassplate/src/base.css',
      dest:  './media/mod_starlink/css'
    },
    mod_starlink: {
      src:  ['./.src/mod_starlink/css/!(_)*.css', '!(bootstrap)*.css' ],
      dest:  './media/mod_starlink/css'
    },
    mod_services: {
      src:   './.src/mod_starlink_services/css/!(_)*.css',
      dest:  './media/mod_starlink_services/css'
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
    src: [ './.src/mod_starlink*/**/*.+(php|xml|html)',
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


const postCSSplugins=[ require('postcss-import')({ path: [".src/_includes"] }), require('postcss-mixins'),
  require('postcss-custom-properties'), require('postcss-apply'), require('postcss-calc'), require('postcss-nesting'), require('postcss-custom-media'),
  require('postcss-media-minmax'), require('postcss-custom-selectors'), require('postcss-color-hwb'), require('postcss-color-gray'),
  require('postcss-color-hex-alpha'),require('postcss-color-function'), require('pixrem'),
  require('postcss-url'), require('postcss-for'), require('postcss-discard-comments'),
  require('autoprefixer')({ 'browsers': '> 1%' }),
  require('css-mqpacker')({sort: true})
];

gulp.task('postcss',
        gulp.parallel(
                ()=>gulp.src(CodePaths.postcss.basscss.src)
                    .pipe($.postcss(postCSSplugins))
                    .pipe($.if(DEBUG, $.debug({title: 'basscss: '})))
                    .pipe(gulp.dest(CodePaths.postcss.mod_starlink.dest)),
                ()=>gulp.src(CodePaths.postcss.mod_starlink.src)
                    .pipe($.postcss(postCSSplugins))
                    .pipe($.if(DEBUG, $.debug({title: 'mod_starlink: '})))
                    .pipe(gulp.dest(CodePaths.postcss.mod_starlink.dest)),
                ()=>gulp.src(CodePaths.postcss.mod_services.src)
                    .pipe($.postcss(postCSSplugins))
                    .pipe($.if(DEBUG, $.debug({title: 'mod_services: '})))
                    .pipe(gulp.dest(CodePaths.postcss.mod_services.dest)),
                ()=>gulp.src(CodePaths.postcss.templates.src)
                    .pipe($.postcss(postCSSplugins))
                    .pipe($.if(DEBUG, $.debug({title: 'templates: '})))
                    .pipe(gulp.dest(CodePaths.postcss.templates.dest))
        )
);

gulp.task('deploy:css',
        gulp.parallel(
              ()=>gulp.src(CodePaths.css.src)
                .pipe($.if(DEBUG, $.debug({title: 'allcss 1: '})))
                .pipe(gulp.dest(CodePaths.css.dest))
        )
);

export const otherAssets = () =>
  gulp.src([CodePaths.js.src, CodePaths.images.src, CodePath.fonts.src, ...CodePaths.other.src])
    .pipe($.if(DEBUG, $.debug({title: 'imagesJsFontsOther: '})))
    .pipe(gulp.dest(CodePaths.js.dest));

gulp.task('build:css',
  gulp.series('postcss', 'deploy:css')
);

gulp.task('build:all',
  gulp.parallel('build:css', otherAssets)
);


export const serve = () => {
  browser.init({
    proxy: "localhost:8000",
    browser: ["chrome"]
  });
  gulp.watch([...CodePaths.postcss.mod_starlink.src, ...CodePaths.postcss.mod_calc.src, ...CodePaths.postcss.mod_services.src, ...CodePaths.postcss.templates.src], postcss_cycle);
};

const postcss_cycle = () => {
  gulp.series(
      'postcss',
      browser.reload()
  );
};
gulp.task('postcss_cycle', postcss_cycle);



