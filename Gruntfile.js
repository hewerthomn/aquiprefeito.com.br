'use strict';

module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			options: {
				separator: ';',
				stripBanners: { block: true, line: true },
			},
			app: {
				dest: 'public/build/js/app.min.js',
				src: [
					'public/packages/angular/angular.min.js',
					'public/packages/angular-animate/angular-animate.min.js',
					'public/packages/angular-focus-it/angular-focus-it.min.js',
					'public/packages/angular-sanitize/angular-sanitize.min.js',
					'public/packages/angular-touch/angular-touch.min.js',
					'public/packages/ngstorage/ngStorage.min.js',
					'public/packages/angular-route/angular-route.min.js',
					'public/packages/angular-bootstrap/ui-bootstrap.min.js',
					'public/packages/angular-bootstrap/ui-bootstrap-tpls.min.js',

					'public/app/app.js',
					'public/app/config.js',
					'public/app/routes.js',

					'public/app/components/home/HomeController.js',

					'public/app/services/MapService.js'
				]
			}
		},

		uglify: {
			app: {
				options: { mangle: false },
				files: {
					'public/build/js/app.min.js': ['public/build/js/app.min.js']
				}
			}
		},

		copy: {
			fonts: {
				files: [{
					expand: true,
					flatten: true,
					src: ['public/font/**.*'],
					dest: 'public/build/font'
				}]
			}
		},

		concat_css: {
			options: {},
			app: {
				dest: 'public/build/css/app.min.css',
				src: [
					'public/css/aquiprefeito_site.css',
					'public/css/app.css',
					'public/packages/bootstrap/dist/css/bootstrap.min.css'
				]
			}
	  },

	  cssmin: {
	  	target: {
		    files: {
		      'public/build/css/app.min.css': ['public/build/css/app.min.css']
		    }
		  }
	  },

		watch: {
			min: {
				files: ['Gruntfile.js', 'public/app/**/*.js', 'public/css/**/*.css'],
				tasks: ['concat:app', 'concat_css'],
				options: {
					atBegin: true,
					liveReload: true
				}
			}
		}
	});

	grunt.registerTask('dev', ['concat', 'concat_css']);
	grunt.registerTask('default', ['concat', 'concat_css', 'cssmin', 'copy']);

	require('time-grunt')(grunt);
	require('jit-grunt')(grunt);
};
