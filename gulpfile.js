'use strict';

/*===============================
=            Loaders            =
===============================*/
var gulp        = require('gulp'),
    compass     = require('gulp-compass'),
    jshint      = require('gulp-jshint'),
    browserSync = require('browser-sync').create();
/*=====  End of Loaders  ======*/


/*==================================
=            References            =
==================================*/
var dev  = './dev/',

    gulpFile       = 'gulpfile.js',
    htmlFiles      = dev + '**/*.html',
    jsFiles        = dev + 'scritps/**/*.js',
    scssFiles      = dev + 'styles/scss/**/*.scss',
    renderersFiles = dev + 'styles/scss/renderers/**/*.scss',
    cssFiles       = dev + 'styles/css/**/*.css',

    scssFolder  = dev + 'styles/scss/renderers',
    cssFolder   = dev + 'styles/css';
/*=====  End of References  ======*/


/*======================================
=            Register tasks            =
======================================*/
gulp.task('default', function () {
    console.log('======================================');
    console.log('                                      ');
    console.log('          Use "$ gulp watch"          ');
    console.log('                                      ');
    console.log('======================================');
});

gulp.task('watch', function () {
    browserSync.init({ server: dev });

    gulp.watch(gulpFile,  ['notification']);
    gulp.watch(scssFiles, ['compass']);
    gulp.watch(jsFiles,   ['jshint']);

    gulp.watch(htmlFiles).on('change', browserSync.reload);
    gulp.watch(jsFiles).on('change', browserSync.reload);
});
/*=====  End of Register tasks  ======*/


/*====================================
=            Config tasks            =
====================================*/
gulp.task('notification', function () {
    console.log('======================================');
    console.log('                                      ');
    console.log('   Use "Ctrl + C" and "$ gulp watch"  ');
    console.log('                                      ');
    console.log('======================================');

    return gulp.src(gulpFile)
        .pipe(jshint({ node: true }))
        .pipe(jshint.reporter('default'))
        .pipe(jslint({
            devel: true,
            node: true
        }))
        .on('error', function (error) {
            console.error(String(error));
        });
});

gulp.task('compass', function () {
    return gulp.src(renderersFiles)
        .pipe(compass({
            config_file: './config.rb',
            css: cssFolder,
            sass: scssFolder
        }))
        .on('error', function (error) {
            console.log(error);
            this.emit('end');
        })
        .pipe(gulp.dest(cssFolder))
        .pipe(browserSync.stream());
});

gulp.task('jshint', function () {
    return gulp.src(jsFiles)
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});
/*=====  End of Config tasks  ======*/