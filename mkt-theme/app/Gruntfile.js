module.exports = function(grunt) {

    // Load all grunt tasks
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // Project paths
        paths: {
            js:         'js/',
            sass:       'scss/',
            css:        'css/',
            image:      'img/',
            sprites:    'sprites/',

            urlPageres: 'http://localhost/mkt-theme/',
            screenshot: 'screenshots/',

            browserSyncUrl: ''
        },

        // Watch: Tasks to watch
        watch: {
            options: {
                nospawn: true
            },
            css: {
                files: ['<%= paths.css %>*.css']
            },
            sass: {
                files: ['<%= paths.sass %>**/*.{scss,sass}'],
                tasks: ['compass', 'autoprefixer:dev']
            },
            js: {
                files: ['<%= paths.js %>**/*.js'],
                tasks: ['uglify']
            },
            img: {
                files: ['<%= paths.image %><%= paths.sprites %>**/*.{png,gif,jpg}'],
                tasks: ['compass','notify:sprite']
            }
        },

        // Prefixer: Prefixer to old's browsers
        autoprefixer: {
            options: {
                browsers: [
                  'Android 2.3',
                  'Android >= 4',
                  'Chrome >= 20',
                  'Firefox >= 24',
                  'Explorer >= 8',
                  'iOS >= 6',
                  'Opera >= 12',
                  'Safari >= 6'
                ],
            },
            dev: {
                src: 'css/main.css',
                dest: 'css/main.css'
            },
            dist: {
                expand: true,
                flatten: true,
                src: '<%= paths.css %>*.css',
                dest: '<%= paths.css %>'
            }
        },

        uglify: {
            dist: {
                files: [{
                    'js/main.min.js' : ['js/main.js']
                }]
            }
        },

        // BrowserSybc: Live reload
        browserSync: {
            files: {
                src : [
                    'app/css/**/*.css',
                    'app/css/**/*.js',
                    '../*.php'
                ],
            },
            options: {
                host: '<%= paths.browserSyncUrl %>',
                delay: 1000,
                server: {
                    baseDir: "."
                },
                watchTask: true,

                ghostMode: {
                    scroll: true,
                    links: true,
                    forms: true,
                    clicks: true
                },
            }
        },

        // Pageres: Generate print screen
        pageres: {
            dist: {
                options: {
                    url: '<%= paths.urlPageres %>',
                    crop: true,
                    dest: '<%= paths.screenshot %>',
                    sizes: [
                        '320x480',     // 320x480   - iPhone (portrait)
                        '480x240',     // 480x240   - iPhone (landscape)
                        '320x568',     // 320x568   - Android
                        '768x1024',    // 768x1024  - iPad (portrait)
                        '1024x768',    // 1024x768  - iPad (landscape) e Desktops
                        '1280x800',    // 1280x800  - Common Desktops
                        '1440x900',    // 1440x900  - Desktops mais recentes
                        '1660x1050'    // 1660x1050 - Tela grande
                    ]
                }
            }
        },

        // Nofity: Notify actions on desktop.
        notify: {
            screenshots: {
                options: {
                    title: 'Screenshots',
                    message: 'Screenshots gerados com sucesso!'
                }
            },
            compressimage: {
                options: {
                    title: 'Imagemin',
                    message: 'Imagens otimizadas com sucesso!'
                }
            },
            sprite: {
                options: {
                    title: 'Sprites',
                    message: 'Atualize seu arquivo para gerar o sprite!'
                }
            },
            buildprod: {
                options: {
                    title: 'Build Prod',
                    message: 'Todas as tarefas executadas!'
                }
            }
        },

        imagemin: {
            prod: {
                options: {
                    optimizationLevel: 7,
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: '<%= paths.image %>',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: '<%= paths.image %>'
                }]
            }
        },

        compass: {
            dist: {
                options: {
                    relativeAssets: true,
                    outputStyle: 'compressed',
                    sassDir: 'scss',
                    cssDir: 'css',
                    imagesDir: 'img'
                }
            }
        }
    });

    // Tasks

    // Screenshot website
    grunt.registerTask('screenshot', [
        'pageres',
        'notify:screenshots'
    ]);

    // Compress Images
    grunt.registerTask('compressimages', [
        'imagemin',
        'notify:compressimage'
    ]);

    // Compress Images
    grunt.registerTask('generatesprites', [
        'compass',
        'notify:sprite'
    ]);

    // Build
    grunt.registerTask('build', [
        'imagemin',
        'autoprefixer:dist',
        'uglify',
        'pageres',
        'notify:buildprod'
    ]);

    // Watch
    grunt.registerTask('w', ['watch']);

    // BrowserSync with Watch
    grunt.registerTask('default', [
        'browserSync',
        'watch'
    ]);
};