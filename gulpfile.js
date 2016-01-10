var gulp = require('gulp');
var sass = require('gulp-sass');
var minifyCss = require('gulp-minify-css');
var cssnext = require('gulp-cssnext');

var paths = {
  'sass':'./app/webroot/css/sass/',
  'css': './app/webroot/css/'
}

gulp.task('sass', function() {
  return gulp.src(paths.sass + 'style.sass')
    .pipe(sass())
    .on('error', function(err) {
      console.log(err.message);
    })
    .pipe(cssnext())
    .pipe(minifyCss())
    .pipe(gulp.dest(paths.css))
});

gulp.task('watch',['sass'], function() {
    gulp.watch(paths.sass + '*.sass', ['sass']);
});

gulp.task('default', ['watch']); 