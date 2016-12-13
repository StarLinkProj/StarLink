'use strict';

import gulp     from 'gulp';
import plugins  from 'gulp-load-plugins';
import yargs    from 'yargs';
import rimraf   from 'rimraf';
const $ = plugins();

// Look for the --production flag
const PRODUCTION = !!(yargs.argv.production);

export function clean(done) {
  rimraf("./9-dist", done);
}

export function scripts() {
  return gulp.src('./1-src/**/*.js')
    .pipe($.if(!PRODUCTION, $.sourcemaps.init()))
    .pipe($.uglify())
    .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
    .pipe(gulp.dest('./9-dist/js'));
}
gulp.task('scripts', scripts);

export function css() {
  return gulp.src('./1-src/css/**/*.css')
  .pipe($.if(!PRODUCTION, $.sourcemaps.init()))
  .pipe($.autoprefixer({
      browsers: ['last 2 versions']
    }))
  .pipe($.order([
          'vendor/*.css',
          '*.css',
          'starlink*/**/*.css'
  ], { base: './1-src/css' }))
  .pipe($.concat('starlink.css'))
/*  .pipe($.cleanCss())*/
  .pipe($.if(!PRODUCTION, $.sourcemaps.write()))
  .pipe(gulp.dest('./9-dist/css'));
}
gulp.task('css', css);

// Copy and compress images
function images() {
  return gulp.src(['1-src/img/**/*', 'media/mod_starlink/images/**/*', 'images/**/*', 'templates/starlink/images/**/*', 'templates/starlink-news/images/**/*', 'templates/starlink-blog/images/**/*' ])
  .pipe($.imagemin())
  .pipe(gulp.dest('./9-dist/img'));
}


const build = gulp.series(clean, gulp.parallel(css /*, scripts, images*/));

export {build};
export default build;

/*
gulp.task('zip',
    gulp.series('build', zip));

function zip() {
}*/
