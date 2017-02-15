/**
 * Created by mao on 11.02.2017.
 */

const production = require('../cfg').production;
const lazypipe = require('lazypipe');

module.exports = (gulp, plugins, options={}) => {

  if (options.watch && !gulp.lastRun('bootstrap:styles')) {
    gulp.watch(options.srcWatch, gulp.series('bootstrap:styles'));
  }

  const productionPipe = lazypipe()
    .pipe(plugins.filter, '**/*.css')             // filter out .map file from the stream
    .pipe(plugins.cssnano, options.cssnano)
    .pipe(plugins.rename, {extname: '.min.css'})
    .pipe(plugins.sourcemaps.write, './')         // produce map for minified css
    .pipe(gulp.dest, options.dest);

  return gulp.src(options.src)
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.sass(options.sassOptions).on('error', plugins.sass.logError))
    .pipe(plugins.if(!production, plugins.sourcemaps.write('./')))    // produce map for non-minified css
    .pipe(gulp.dest(options.dest))
    .pipe(plugins.if(production, productionPipe()))
    .pipe(options.browserSync.reload({stream: true}));

};