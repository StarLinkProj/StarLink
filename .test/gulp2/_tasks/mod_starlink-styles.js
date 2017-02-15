/**
 * Created by mao on 11.02.2017.
 */

const production = require('../cfg').production;
const lazypipe = require('lazypipe');

module.exports = (gulp, plugins, options={}) => {

  if (options.watch && !gulp.lastRun('mod_starlink:styles')) {
    gulp.watch(options.srcWatch, gulp.series('mod_starlink:styles'));
  }

  const productionPipe = lazypipe()
    .pipe(plugins.filter, '**/*.{,p}css')         // filter out .map file from the stream
    .pipe(plugins.cssnano, options.cssnano)
    .pipe(plugins.rename, {extname: '.min.css'})
    .pipe(plugins.sourcemaps.write, './')         // produce map for minified css
    .pipe(gulp.dest, options.dest);

  console.log(`src: ${options.src}`);

  return gulp.src(options.src)
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.postcss(options.postcss))
    .pipe(plugins.rename({extname: '.css'}))
    .pipe(plugins.if(!production, plugins.sourcemaps.write('./')))    // produce map for non-minified css
    .pipe(gulp.dest(options.dest))
    .pipe(plugins.if(production, productionPipe()))
    .pipe(options.browserSync.reload({stream: true}));

};