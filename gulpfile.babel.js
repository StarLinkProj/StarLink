'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import yargs    from 'yargs';
import rimraf   from 'rimraf';
const $ = plugins();

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
  }
}
// Look for the --production flag
const PRODUCTION = !!(yargs.argv.production);

export function clean(done) {
  rimraf("./.dist", done);
}

export function scripts() {
  return gulp.src('./.src/**/*.js')
    .pipe($.if(!PRODUCTION, $.sourcemaps.init()))
    .pipe($.uglify())
    .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
    .pipe(gulp.dest('./.dist/js'));
}
gulp.task('scripts', scripts);

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
gulp.task('css', css);

// Copy and compress images
export function images() {
  return gulp.src(['.src/img/**/*', 'media/mod_starlink/images/**/*', 'images/**/*', 'templates/starlink/images/**/*', 'templates/starlink-news/images/**/*', 'templates/starlink-blog/images/**/*' ])
  .pipe($.imagemin())
  .pipe(gulp.dest('./.dist/images'));
}

export function postcss() {
  const plugins = [
    require('postcss-import')(),
    require('precss')(),
    require('postcss-sass-extend')(),
    require('postcss-color-function')(),
    require('postcss-color-gray')(),
    require('postcss-cssnext')({ browsers: ['> 1%'] }),
    require('css-mqpacker')()
  ];
  return gulp.src(['.src/mod_starlink/media/css/**/*.css'])
  .pipe($.postcss(plugins))
  .pipe($.if(PRODUCTION, $.cssnano()))
  .pipe(gulp.dest('.dist/mod_starlink/media/css'))
  .pipe(gulp.dest('media/mod_starlink/css'));
}
gulp.task('postcss', postcss);

const build = gulp.series(clean, gulp.parallel(css /*, scripts, images*/));

export {build};
export default build;

/*
gulp.task('zip',
    gulp.series('build', zip));

function zip() {
}*/
