'use strict';

/*===============================
=            Loaders            =
===============================*/
var gulp        = require('gulp'),
    compass     = require('gulp-compass'),
    jshint      = require('gulp-jshint'),
    browserSync = require('browser-sync').create(),
    usemin      = require('gulp-usemin'),
    replace     = require('gulp-replace'),
    runSequence = require('run-sequence');
/*=====  End of Loaders  ======*/


/*==================================
=            References            =
==================================*/
var dev     = 'dev/',
    build = 'wordpress/wp-content/themes/mkt-virtual/',

    gulpFile       = 'gulpfile.js',
    htmlFiles      = dev + '**/*.html',
    imgFiles       = dev + 'imgs/**/*',
    scriptFiles    = dev + 'scritps/**/*',
    scssFiles      = dev + 'styles/scss/**/*',
    renderersFiles = dev + 'styles/scss/renderers/**/*',
    cssFiles       = dev + 'styles/css/**/*',

    scssFolder = dev + 'styles/scss/renderers',
    cssFolder  = dev + 'styles/css';
/*=====  End of References  ======*/


/*======================================
=            Register tasks            =
======================================*/
gulp.task('default', function () {
    console.log('======================================');
    console.log('                                      ');
    console.log('      Use "$ gulp watch | build"      ');
    console.log('                                      ');
    console.log('======================================');
});

gulp.task('watch', function () {
    browserSync.init({ server: dev });

    gulp.watch(gulpFile,    ['notification']);
    gulp.watch(scssFiles,   ['compass']);
    gulp.watch(scriptFiles, ['jshint']);

    gulp.watch(htmlFiles).on('change', browserSync.reload);
    gulp.watch(scriptFiles).on('change', browserSync.reload);
});

gulp.task('build', function () {
    runSequence('copy', 'usemin', 'replace');
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
        .pipe(jshint.reporter('default'));
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
    return gulp.src(scriptFiles)
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});

gulp.task('copy', function () {
    gulp.src(imgFiles)
        .pipe(gulp.dest(build + 'imgs'));

    gulp.src(scriptFiles)
        .pipe(gulp.dest(build + 'scripts'));
});

gulp.task('usemin', function () {
    return gulp.src(htmlFiles)
        .pipe(usemin())
        .pipe(gulp.dest(build));
});

gulp.task('replace', function () {
    return gulp.src(build + 'style.css')
        .pipe(replace(/..\/..\/imgs\//g, 'imgs/'))
        .pipe(gulp.dest(build));
});
/*=====  End of Config tasks  ======*/