/**
 * Created by mao on 30.01.2017.
 */

/*@  Debug things */
const loggy=require('../../../.gulp/helpers').loggy;

module.exports = function (gulp, plugins, taskOptions) {
  const { src, dest, options = {} } = taskOptions;

  return function markupTask() {
    if (options.watch && !gulp.lastRun(markupTask)) {
      gulp.watch(options.watchFiles, markupTask)
        .on('change', (path, stats) => options.reload );
    }

    return gulp.src(src, options.src)
      .pipe(gulp.dest(dest, options.dest))
      .pipe(plugins.if(options.reload, options.reload({ stream: true })));
  }
};


