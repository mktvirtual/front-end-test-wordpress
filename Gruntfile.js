module.exports = function( grunt ) {

  grunt.initConfig({

    uglify : {
      options : {
        mangle : false
      },

      my_target : {
        files : {
          'assets/js/main.js' : [ 'assets/_js/scripts.js' ]
        }
      }
    }, // uglify



    sass : {
      dist : {
        options : { style : 'compressed' },
        files : {
          'assets/css/style.css' : 'assets/_sass/style.sass'
        }
      }
    }, // sass



    watch : {
      dist : {
        files : [
          'assets/_js/**/*',
          'assets/_sass/**/*'
        ],

        tasks : [ 'uglify', 'sass' ]
      }
    } // watch

  });


  // Plugins do Grunt
  grunt.loadNpmTasks( 'grunt-contrib-uglify' );
  grunt.loadNpmTasks( 'grunt-contrib-sass' );
  grunt.loadNpmTasks( 'grunt-contrib-watch' );


  // Tarefas que serão executadas
  grunt.registerTask( 'default', [ 'uglify', 'sass' ] );

  // Tarefa para Watch
  grunt.registerTask( 'w', [ 'watch' ] );

  //icon
  grunt.loadNpmTasks('grunt-grunticon');

};