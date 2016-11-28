'use strict';
import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
const $ = plugins();
//import requireDir from 'require-dir';
import yargs    from 'yargs';
import rimraf   from 'rimraf';
import path     from 'path';
import {create as bcCreate} from 'browser-sync';
const browser = bcCreate();
import paths from './config.paths';

//requireDir(__dirname + '/.gulp', { recurse: true } );

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

// helper function to move modules' assets to Joomla /media folder
const assetRename = path => { path.dirname = path.dirname.replace( '/media', ''); }

const paths = {
  postcss: {
    basscss: {
      src:   './.src/bassplate/src/base.css',
      build: './.src/bassplate/css',
      dest:  './.src/mod_starlink/media/css'
    },
    mod_starlink: {
      src: [
        './.src/mod_starlink/.src/*.css', '!./.src/mod_starlink/.src/_*'
      ],
      dest: './.src/mod_starlink/media/css'
    },
    mod_services: {
      src:   './.src/mod_starlink_services/.src/*.css',
      dest: './.src/mod_starlink_services/media/css'
    }
  },
  css: {
    src:  './.src/mod_starlink*/**/css/*',
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
  other: {
    src: [
      './.src/mod_starlink*/*',
      './.src/mod_starlink*/!(media|.src)/**/*',
      './.src/mod_starlink*/media/!(css|fonts|images|js)/**/*'
    ],
    dest: './.media'
  },
  templates: {
    src:  './.src/templates/**/*.*',
    dest: './templates'
  }
};

var postcssImport = require('postcss-import');
const postCSSplugins = [
  postcssImport({path: [ ".src/_includes" ]}), require('postcss-mixins'),
  require('postcss-custom-properties'), require('postcss-apply'), require('postcss-calc'), require('postcss-nesting'), require('postcss-custom-media'),
  require('postcss-media-minmax'), require('postcss-custom-selectors'), require('postcss-color-hwb'), require('postcss-color-gray'),
  require('postcss-color-hex-alpha'),require('postcss-color-function'), require('pixrem'),
  require('postcss-url'), require('postcss-for'), require('postcss-discard-comments'),
  require('autoprefixer')({ 'browsers': '> 1%' }),
  require('css-mqpacker')({sort: true})
];

gulp.task('postcss',
  gulp.parallel(
      gulp.src(paths.postcss.basscss.src)
        .pipe($.postcss([postcssImport({from: paths.postcss.basscss.src}), ...postCSSplugins]))
        .pipe($.if(DEBUG, $.debug({title: 'basscss: '})))
        .pipe(gulp.dest(paths.postcss.basscss.build))
        .pipe(gulp.dest(paths.postcss.mod_starlink.dest)),
      gulp.src(paths.postcss.mod_starlink.src)
        .pipe($.postcss(postCSSplugins))
        .pipe($.if(DEBUG, $.debug({title: 'mod_starlink: '})))
        .pipe(gulp.dest(paths.postcss.mod_starlink.dest)),
      gulp.src(paths.postcss.mod_services.src)
        .pipe($.postcss(postCSSplugins))
        .pipe($.if(DEBUG, $.debug({title: 'mod_services: '})))
        .pipe(gulp.dest(paths.postcss.mod_services.dest))
  )
);

gulp.task('deploy:css',
  gulp.parallel(
    gulp.src(paths.css.src)
      .pipe($.rename(assetRename))
      .pipe($.if(DEBUG, $.debug({title: 'allcss 1: '})))
      .pipe(gulp.dest(paths.css.dest)),
    gulp.src(paths.postcss.templates.src)
      .pipe($.if(DEBUG, $.debug({title: 'allcss 2: '})))
      .pipe($.postcss(postCSSplugins))
      .pipe(gulp.dest(paths.postcss.templates.dest))
  )
);

export const processImagesJsFontsOther = () =>
  gulp.src([paths.js.src, paths.images.src, path.fonts.src, ...paths.other.src])
    .pipe($.rename(assetRename))
    .pipe($.if(DEBUG, $.debug({title: 'imagesJsFontsOther: '})))
    .pipe(gulp.dest(paths.js.dest));

gulp.task('build:css',
  gulp.series('postcss', 'deploy:css')
);

gulp.task('build:all',
  gulp.parallel('build:css', processImagesJsFontsOther)
);


export const serve = () => {
  browser.init({
    proxy: "localhost:8000",
    browser: ["chrome"]
  });
  gulp.watch([...paths.postcss.mod_starlink.src, ...paths.postcss.mod_calc.src, ...paths.postcss.mod_services.src, ...paths.postcss.templates.src], postcss_cycle);
};

const postcss_cycle = () => {
  gulp.series(
      'postcss',
      browser.reload()
  );
};
gulp.task('postcss_cycle', postcss_cycle);



