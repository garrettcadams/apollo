/** NPM Modules */
var gulp = require('gulp');
var gutil = require('gulp-util');
var config = require('./assets/config.json');
var node_path = require('path');
var foreach = require('gulp-foreach');
var plumber = require('gulp-plumber');
var $if  = require('gulp-if');
var argv = require('yargs').argv;
var rename = require('gulp-rename');
var del = require('del');

var maps = require('gulp-sourcemaps');
var changed = require('gulp-changed');
var sequence = require('gulp-sequence');

var sass = require('gulp-sass');
var mediaQuery  = require('gulp-group-css-media-queries');
var nano = require('gulp-cssnano');

var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var buffer = require('vinyl-buffer');
var source = require('vinyl-source-stream');
var assign = require('lodash.assign');
var watchify = require('watchify');
var browserify = require('browserify');
var browsersync = require('browsersync');




// Production flag
var production = argv.production;

// Paths
var enter = config.paths.enter;
var dest_base = production ? config.paths.dist : config.paths.src;

// Enter paths for file types
var base = {
  'sass': enter + 'sass/main/*.scss',
  'js': {
    'single': enter + 'js/single/*.js',
    'main': enter + 'js/main.js',
    'modules': enter + 'js/modules'
  }
}

// Destination paths for file types
var dest = {
  'css': dest_base + 'css/',
  'js': dest_base + 'js/'
};




/**
 * CLEAN TASKS
 *
 * Remove css files in distribution directory
 * Remove js files in distribution directory
 */
 gulp.task('clean_css', function () {
   del(dest.css);
 });

 gulp.task('clean_js', function () {
   del(dest.js);
 });

/****************** SASS AND CSS ******************/

/**
 * SASS TASK
 *
 * Runs foreach on every file in 'sass/main'
 */
gulp.task('build_sass', function() {
  gulp.src( base.sass )
    .pipe(foreach( function(stream, file) {
      // Get base file name, rename it based on argv
      var namebase = node_path.basename(file.path, '.scss');
      var name = production ? namebase + '.min.css' : namebase + '.css';

      return stream
        .pipe( $if( !production, plumber() ) )
        .pipe( changed( dest.css) )                     // Only run on changed files
        .pipe( $if( !production, maps.init() ) )        // If no production flag, generate maps
          .pipe(sass().on('error', sass.logError))      // Compile sass
          .pipe( $if( production, mediaQuery() ) )      // Reorg media queries
          .pipe(nano({ autoprefixer: { add: true } }))  // Shrink that css
          .pipe(rename(name))                           // Rename
        .pipe( $if( !production, maps.write('.') ) );   // If no production flag, write maps
    }) )
    .pipe( gulp.dest( dest.css ) );                     // Ship it
});




/****************** JS ******************/


/**
 * LINT TASKS
 *
 * Run single js through the linter
 * Run main browserify file through the linter
 */
gulp.task('lint_single', function(){
  return gulp.src( base.js.single )
    .pipe( jshint() )
    .pipe( jshint.reporter('jshint-stylish-source') );
});

gulp.task('lint_main', function(){
  return gulp.src( base.js.single )
    .pipe( jshint() )
    .pipe( jshint.reporter('jshint-stylish-source') );
});





/**
 * SINGLE JS TASK
 *
 * For non browserified files saved in `single`
 */
gulp.task('build_single_js', ['lint_single'], function(){
  gulp.src( base.js.single )
    .pipe(foreach( function(stream, file) {
      // Get base file name, rename it based on argv
      var namebase = node_path.basename(file.path, '.js');
      var name = production ? namebase + '.min.js' : namebase + '.js';

      return stream
        .pipe( $if( !production, plumber() ) )
        .pipe( $if( !production, maps.init() ) )      // If no production flag, generate maps
          .pipe( changed( dest.js) )                  // Only run on changed files
          .pipe( uglify() )
        .pipe( $if( !production, maps.write('.') ) );   // If no production flag, write maps

    }) )
  .pipe( gulp.dest( dest.js ) );                     // Ship it
});





/**
 * BROWSERIFY TASK
 *
 *
 */
var customOpts = {
 entries: [base.js.main],
 paths: ['./node_modules', base.js.modules],
 debug: true
};
var opts = assign({}, watchify.args, customOpts);
var bundler = watchify(browserify(opts));

// Babel transform
bundler.transform(babelify.configure({
    sourceMapRelative: 'base.js.main'
}));

// function bundle() {

//   gutil.log('Compiling JS...');

//   return bundler.bundle()
//     .on('error', function (err) {
//         gutil.log(err.message);
//         browserSync.notify("Browserify Error!");
//         this.emit("end");
//     })
//     .pipe(source('bundle.js'))
//     .pipe(gulp.dest('./app/js/dist'))
//     .pipe(browserSync.stream({once: true}));
// }

function bundle() {
  gutil.log('Compiling JS...');

  return bundler.bundle()
    // log errors if they happen
    .on('error', gutil.log.bind(gutil, 'Browserify Error'))
    .pipe(source('bundle.js'))
    // optional, remove if you don't need to buffer file contents
    .pipe( buffer() )
    // optional, remove if you dont want sourcemaps
    .pipe(maps.init({loadMaps: true})) // loads map from browserify file
       // Transforms go here
       .pipe( uglify() )
    .pipe(maps.write('.')) // writes .map file
    .pipe(gulp.dest(dest.js));
}


/**
 * Browserify Gulp Task (Alias)
 */
gulp.task('build_bundle', function () {
  return bundle();
});




/**
 * COPY JQUERY
 *
 * Copy jQuery for local fallback
 */
gulp.task('copy_jquery', function() {
  return gulp.src('./node_modules/jquery/dist/jquery.min.js')
    .pipe( gulp.dest( dest.js ) );
});





/**
 * BUILD TASK
 *
 * Start the whole show. Run to start a project up.
 */
// gulp.task('build', sequence(
//   'copy_jquery',
//   'build_sass',

// );


