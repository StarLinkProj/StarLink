/**
 * Created by mao on 30.01.2017.
 */

/*@  Debug things */
const loggy = require('../../../.gulp/helpers.js').loggy;

module.exports = function (gulp, plugins, taskOptions) {
  let { src, dest, options = {} } = taskOptions;
  options.src = options.src || '';

  return function stylesTask() {
    if (options.watch && !gulp.lastRun(stylesTask)) {
      gulp.watch(options.watchFiles, stylesTask);
    }

    return gulp.src(src, options.src)
      .pipe(plugins.postcss(options.postcss))
      .pipe(plugins.rename({extname:'.css'}))
      .pipe(gulp.dest(dest, options.dest))
      .pipe(plugins.if(options.reload, options.reload({ stream: true })))
  }
};


