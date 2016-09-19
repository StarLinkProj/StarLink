/**
 * Created by mao on 13.09.2016.
 */

var gulp = require('gulp');
var sass = require('gulp-sass');

var config = {
  bootstrapDir: './bower_components/bootstrap-sass',
  cssDir: './css',
  sassDir: './scss',
  fontsDir: './fonts'
};

gulp.task('css', function() {
  return gulp.src(config.sassDir+'/am_app.scss')
    .pipe(sass({
      includePaths: [config.bootstrapDir + '/assets/stylesheets'],
    }))
    .pipe(gulp.dest(config.cssDir));
});

gulp.task('fonts', function() {
  return gulp.src(config.bootstrapDir + '/assets/fonts/**/*')
    .pipe(gulp.dest(config.fontsDir));
});

gulp.task('default', ['css', 'fonts']);