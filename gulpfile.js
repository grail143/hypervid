const gulp = require('gulp');
const sass = require('gulp-sass');
const webpack = require('webpack-stream');

gulp.task('sass', function(){
  return gulp.src('./sass/*.scss')
    .pipe(sass()) 
    .pipe(gulp.dest('./css'))
});

gulp.task('webpack', function () {
  return gulp
    .src('src/*.js')
    .pipe(
      webpack({ 
		mode: "development",
		output: {filename: 'main.js'} 
	  })
    )
    .pipe(gulp.dest('dist/'));
});

gulp.task('watch', function(){
	gulp.watch('./sass/*.scss', gulp.series(['sass']));
	gulp.watch('src/*.js', gulp.series(['webpack']));
});