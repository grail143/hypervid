const gulp = require('gulp');
const sass = require('gulp-sass');
const webpack = require('webpack-stream');
const concat = require('gulp-concat');


gulp.task('sass', function(){
  return gulp.src('./sass/style.scss')
    .pipe(sass({
      includePaths: ['./node_modules/purecss-sass/vendor/assets/stylesheets/']
    }))
	.pipe(concat('style.css'))
    .pipe(gulp.dest('./css'))
});

gulp.task('js', function () {
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
	gulp.watch('src/*.js', gulp.series(['js']));
});
