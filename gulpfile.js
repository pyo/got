var gulp = require('gulp');
var watch = require('gulp-watch');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var image = require('gulp-image');
var compass = require('gulp-compass');
var minifyCSS = require('gulp-minify-css');
var jshint = require('gulp-jshint');
var stylish = require('jshint-stylish');

var handleError = function(err) {
	console.log(err.toString());
	this.emit('end');
};

gulp.task('javascript', function() {
	gulp.src([
		'javascripts/vendor/jquery.cookie.js',
		'javascripts/mustache.js',
		'javascripts/socialite.min.js',
		'javascripts/lazyload.min.js',
		'javascripts/vendor/flexslider/jquery.flexslider-min.js',
		'javascripts/fitvids.js',
		'javascripts/vendor/fancybox/source/jquery.fancybox.pack.js',
		'javascripts/got_video.js',
		'javascripts/site.js'
	])
	.pipe(concat('site.ugly.js'))
	.pipe(uglify())
	.on('error', handleError)
	.pipe(gulp.dest('javascripts/dist'));
});

gulp.task('lint', function() {
    gulp.src('assets/js/app.js')
    .pipe(jshint())
    .pipe(jshint.reporter(stylish));
});

gulp.task('watch', function() {
	gulp.watch('assets/js/**/*.js', ['lint', 'javascript']);
});

gulp.task('default', ['lint', 'javascript', 'watch']);