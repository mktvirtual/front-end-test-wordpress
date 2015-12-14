module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			dist: {
				files: {
					'style.css' : 'sass/style.scss'
				}
			}
		},
		compass: {
	    	dist: {
	      		options: {
	        		config: 'config.rb'
	    		}
	   		}
		},
		watch: {
			css: {
				files: '**/*.scss',
				tasks: ['compass']
			},
			development: {
                files: [
                'style.css'
                ],
                tasks: ['minify']
            }
		},
		cssmin: {
		  options: {
		    shorthandCompacting: false,
		    roundingPrecision: -1
		  },
		  target: {
		    files: {
		      'style.css': ['style.css']
		    }
		  }
		},
		ftp_push: {
		    your_target: {
				options: {
				authKey: "key1",
				host: "ftp.focostreinamentos.com.br",
				dest: "/public_html/logo/wp-content/themes/logo",
				port: 21
				},
		      	files: [
		        	{
						expand: true,
						cwd: '.',
						src: ['style.css']
		        	}
		      	]
		    }
		}
	});
	grunt.registerTask('minify', ['cssmin', 'ftp_push']);
	grunt.registerTask('default',['watch']);

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-ftp-push');
}