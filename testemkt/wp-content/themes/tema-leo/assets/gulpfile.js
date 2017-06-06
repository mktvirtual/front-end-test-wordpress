const   gulp                 = require('gulp'),
    sass             = require('gulp-sass'),
    autoprefixer         = require('gulp-autoprefixer'),
    plumber              = require('gulp-plumber'),
    bs               = require('browser-sync');
    uglify           = require('gulp-uglify');
    rename       = require('gulp-rename'),
    concat       = require('gulp-concat'),
    cssmin       = require('gulp-cssmin'),
    notify           = require("gulp-notify"),
    imagemin = require('gulp-imagemin');




//PATHS FILES
var paths = {
    src : {
        sass    :   'src/scss/**/*.scss',
        js      :   'src/js/**/*.js',
        img     :   'src/image/**'
    } ,
    dest : {
        sass    :   'build/css',
        js      :   'build/js',
        img     :   'build/image/'
    }
}


// Live reload (PHP)
 gulp.task('bs', function() {
  bs.init({
    proxy: "http://localhost/testemkt",
    files: ["./*.php"]
  })
})



// Style SASS & Autoprefixer Min
gulp.task('css', function() {
 gulp.src(paths.src.sass)
     .pipe(plumber())
     .pipe(sass())
     .pipe(autoprefixer({
      browers: ['last 30 versions'],
      cascade: false
    }))
     .pipe(cssmin())
     .pipe(plumber.stop())
     .pipe(gulp.dest(paths.dest.sass))
     .pipe(bs.reload({
         stream: true
     }))
});



// Javascript Min
gulp.task('jsmin', function() {
    gulp.src(['src/js/jquery-3.2.1.min.js', paths.src.js])
        .pipe(plumber())
        .pipe(concat('concat.js'))
        .pipe(gulp.dest(paths.dest.js))
        .pipe(rename('main.js'))
        .pipe(uglify())
        .pipe(plumber.stop())
        .pipe(gulp.dest(paths.dest.js));
});


//Image compressor
gulp.task('imagemin', function(){
  gulp.src( paths.src.img )
    .pipe(imagemin({
    verbose: true
    }))
    .pipe(gulp.dest( paths.dest.img ));
});

//Watch files
gulp.task('watch', ['bs'], function (){
    gulp.watch(paths.src.js, ['jsmin']);
    gulp.watch(paths.src.sass, ['css']);
    gulp.watch(paths.src.img, ['imagemin']);
    gulp.watch("./**.php").on('change', bs.reload);
})

gulp.task('default', ['css', 'jsmin' ,'imagemin', 'watch']);