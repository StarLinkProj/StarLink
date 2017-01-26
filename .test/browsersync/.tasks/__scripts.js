/**
 * Created by mao on 30.01.2017.
 */


module.exports = function (gulp, plugins, taskOptions) {
  const { src, dest, options = {} } = taskOptions;

  return function scriptsTask() {
    if (options.watch && !gulp.lastRun(scriptsTask)) {
      gulp.watch(options.watchFiles, scriptsTask)
        .on('change', (path, stats) => options.reload );
    }

    return gulp.src(src, options.src)
      .pipe(gulp.dest(dest, options.dest))
      .pipe(plugins.if(options.reload, options.reload({ stream: true })))
  }
};


