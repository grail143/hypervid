const gulp = require('gulp');
const sass = require('gulp-sass');
const webpack = require('webpack-stream');
const concat = require('gulp-concat');


gulp.task('sass', function(){
  return gulp.src('./dev/sass/style.scss')
    .pipe(sass({
      includePaths: ['./node_modules/purecss-sass/vendor/assets/stylesheets/']
    }))
	.pipe(concat('style.css'))
    .pipe(gulp.dest('./dist/css'))
});

gulp.task('js', function () {
  return gulp
    .src('./dev/src/*.js')
    .pipe(
      webpack({ 
		mode: "development",
		output: {filename: 'script.js'} 
	  })
	)
	
    .pipe(gulp.dest('./dist/js'));
});

gulp.task('watch', function(){
	gulp.watch('./dev/sass/*.scss', gulp.series(['sass']));
	gulp.watch('./dev/src/*.js', gulp.series(['js']));
});
