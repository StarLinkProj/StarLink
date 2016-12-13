'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import requireDir from 'require-dir';
import yargs    from 'yargs';
import rimraf   from 'rimraf';
import merge    from 'merge-stream';
import path     from 'path';
import {create as bcCreate} from 'browser-sync'; // var browser = require('browser-sync').create();
const browser = bcCreate();
const $ = plugins();
requireDir('./.gulp/tasks', { recurse: true } );

const paths = {
  images: {
    src: [
      '.src/img/**/*',
      'images/**/*',
      'templates/starlink/images/**/*',
      'templates/starlink-news/images/**/*',
      'templates/starlink-blog/images/**/*'
    ],
    dest: 'media/mod_starlink/images/**/*'
  },
  css: {
    src: [
      '.src/mod_starlink/media/css/*.css'
    ],
    dest: [
      '.dist/mod_starlink/media/css',
      'media/mod_starlink/css'
    ]
  },
  postcss: {
    src: {
      vendor: [
        '.src/mod_starlink/media/css/bootstrap.css',
        '.src/mod_starlink/media/css/font-default.css'
      ],
      calculator: [
        '.src/mod_starlink_calculator_outsourcing/media/css/*.css'
      ],
      services: [
        '.src/mod_starlink_services/media/css/*.css'
      ],
      main: [
        '.src/mod_starlink/media/css/styles.css'
      ],
      templates: [
        '.src/templates/**/*.css'
      ]
    },
    build:
      '.build/mod_starlink/media/css',
    dest: {
      main: [
        '.dist/mod_starlink/media/css',
        'media/mod_starlink/css'
      ],
      templates: 'templates',
      services: [
        '.dist/mod_starlink_services/media/css',
        'media/mod_starlink_services/css'
      ],
      calculator: [
        '.dist/mod_starlink_calculator_outsourcing/media/css',
        'media/mod_starlink_calculator_outsourcing/css'
      ]
    }
  }
};


// Look for the --production flag
const PRODUCTION = !!(yargs.argv.production);

export const clean = (done) => rimraf("./.dist", done);
export function css() {
  return gulp.src('./.src/css/**/*.css')
  .pipe($.if(!PRODUCTION, $.sourcemaps.init()))
  .pipe($.autoprefixer({
      browsers: ['last 2 versions']
    }))
  .pipe($.order([
          'vendor/*.css',
          '*.css',
          'starlink*/**/*.css'
  ], { base: './.src/css' }))
  .pipe($.concat('starlink.css'))
/*  .pipe($.cleanCss())*/
  .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
  .pipe(gulp.dest('./.dist/css'));
}
export const styleGuide = () => {
  return true;
};

const postCSSplugins = [
  require('postcss-import')(),
  require('postcss-use')(),
  require('postcss-sass-extend')(),
  require('postcss-mixins')(),
  require('postcss-for')(),
  require('postcss-simple-vars')(),
  require('postcss-nested')(),
  require('postcss-utilities')(),
  require('precss')(),
  require('postcss-color-function')(),
  require('postcss-color-gray')(),
 // require('postcss-cssnext')({ browsers: ['> 1%'] }),
 // require('postcss-bem')({style: 'suit'}),
  require('css-mqpacker')({sort: true})
];

function postcssVersusOneFile(projectDir, srcFile, absSrcFile) {
  var compareFileAgainst = path.join( paths.postcss.build, "styles.css" );

  var destinationFile = path.join( projectDir, compareFileAgainst );
  return destinationFile;
}

// all *.css files will be compared against
// .build/mod_starlink/media/css/styles.css

export const compilePostcssToCss = () =>
  gulp.src(paths.css.src)
    .pipe($.newy(postcssVersusOneFile))
    .pipe($.postcss(postCSSplugins))
    .pipe(gulp.dest(paths.postcss.build));

const cssPaths = {
  src:  [ ".src/mod_starlink*/**/*.css", ".src/templates/**/*.css" ],
  dest:   ".build/compiled_css"
};

function postcssfile2css(projectDir, srcFile, absSrcFile) {
  var stripPath = ".src";
  var destDir = ".build/compiled_css";
  var re = new RegExp("^\/.*"+stripPath+"\/");
  var relativeSourceFile = absSrcFile.replace(re, "");
  var destinationFile = path.join(projectDir, destDir, relativeSourceFile);
  // srcFile is error.service.coffee
  // destination file returned is
  // /home/one/github/foo/compiled/js/fooBar/services/error-services/error.service.js
  return destinationFile;
}
export const pcss = () => gulp.src(cssPaths.src, { base: ".src" })
                              .pipe($.print())
                              //.pipe($.sourcemaps.init())
                              .pipe($.postcss(postCSSplugins))
                              //.pipe($.sourcemaps.write("."))
                              .pipe(gulp.dest(cssPaths.dest));
gulp.task("build:copy", function() {
  return gulp.src(path.join(cssPaths.dest, "mod_starlink/media/css/styles.css"))
  .pipe(gulp.dest("media/mod_starlink/css"));
});

export function postcssVendors() {
  return gulp.src(paths.postcss.src.vendor)
    .pipe(gulp.dest(paths.postcss.dest.main[0]))
    .pipe(gulp.dest(paths.postcss.dest.main[1]));
}

const postcssCalculator = () => gulp.src(paths.postcss.src.calculator)
  .pipe($.postcss(postCSSplugins))
  .pipe(gulp.dest(paths.postcss.dest.calculator[0]))
  .pipe(gulp.dest(paths.postcss.dest.calculator[1]));

const postcssServices = () => gulp.src(paths.postcss.src.services)
  .pipe($.postcss(postCSSplugins))
  .pipe(gulp.dest(paths.postcss.dest.services[0]))
  .pipe(gulp.dest(paths.postcss.dest.services[1]));

const postcssTemplates = () => gulp.src(paths.postcss.src.templates)
  .pipe($.postcss(postCSSplugins))
  .pipe(gulp.dest(paths.postcss.dest.templates));

const postcssMain = () => gulp.src(paths.postcss.src.main)
  .pipe($.sourcemaps.init())
  .pipe($.postcss(postCSSplugins))
  .pipe($.if(PRODUCTION, $.cssnano()))
  .pipe($.sourcemaps.write())
  .pipe(gulp.dest(paths.postcss.dest.main[0]))
  .pipe(gulp.dest(paths.postcss.dest.main[1]));

export function postcssnew() {
  return gulp.series(gulp.parallel(postcssVendors, postcssMain), gulp.parallel(postcssCalculator, postcssServices, postcssTemplates));
}

export function postcss() {
  return merge(
          gulp.src(paths.postcss.src.vendor)
            .pipe(gulp.dest(paths.postcss.dest.main[0]))
            .pipe(gulp.dest(paths.postcss.dest.main[1])),
          gulp.src(paths.postcss.src.calculator)
            .pipe($.postcss(postCSSplugins))
            .pipe(gulp.dest(paths.postcss.dest.calculator[0]))
            .pipe(gulp.dest(paths.postcss.dest.calculator[1])),
          gulp.src(paths.postcss.src.services)
            .pipe($.postcss(postCSSplugins))
            .pipe(gulp.dest(paths.postcss.dest.services[0]))
            .pipe(gulp.dest(paths.postcss.dest.services[1])),
          gulp.src(paths.postcss.src.templates)
            .pipe($.postcss(postCSSplugins))
            .pipe(gulp.dest(paths.postcss.dest.templates)),
          gulp.src(paths.postcss.src.main)
            .pipe($.sourcemaps.init())
            .pipe($.postcss(postCSSplugins))
            .pipe($.if(PRODUCTION, $.cssnano()))
            .pipe($.sourcemaps.write())
            .pipe(gulp.dest(paths.postcss.dest.main[0]))
            .pipe(gulp.dest(paths.postcss.dest.main[1]))
  );
}

const server = () =>
  browser.init({
    server: {
      baseDir: '.'
    }
  });

gulp.task('css', css);
const watch = () => {
  gulp.watch(cssPaths.src, gulp.series(pcss, "build:copy", browser.reload));
  gulp.watch(".src/templates/starlink*/**/*.php", browser.reload);
};
export const post = gulp.series(pcss, server, watch);
export default post;

export const build = gulp.series(clean, gulp.parallel(css /*, scripts, images*/));

