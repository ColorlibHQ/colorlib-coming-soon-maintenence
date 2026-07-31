'use strict';
module.exports = function( grunt ) {

	// load all tasks
	require( 'load-grunt-tasks' )( grunt, { scope: 'devDependencies' } );

	grunt.config.init( {
		pkg: grunt.file.readJSON( 'package.json' ),

		dirs: {
			css: '/assets/css',
			js: '/assets/js'
		},
		cssmin: {
			target: {
				files: [
					{
						expand: true,
						cwd: 'assets/css',
						src: [ '*.css', '!*.min.css' ],
						dest: 'assets/css',
						ext: '.min.css'
					},
					// The per-template CSS is the bulk of the front-end payload,
					// so minify it too - ccsm_style_url() serves .min.css
					// whenever the minified sibling exists.
					{
						expand: true,
						cwd: 'templates',
						src: [ '*/css/*.css', '!*/css/*.min.css' ],
						dest: 'templates',
						ext: '.min.css'
					}
				]
			}
		},
		clean: {
			css: [ 'assets/css/*.min.css', 'templates/*/css/*.min.css' ],
			init: {
				src: [ 'build/' ]
			},
		},
		copy: {
			build: {
				expand: true,
				src: [
					'**',
					'!node_modules/**',
					'!vendor/**',
					'!build/**',
					'!readme.md',
					'!README.md',
					'!phpcs.ruleset.xml',
					'!package-lock.json',
					'!svn-ignore.txt',
					'!Gruntfile.js',
					'!package.json',
					'!composer.json',
					'!composer.lock',
					'!set_tags.sh',
					'!*.zip',
					'!nbproject/**',
					'!CLAUDE.md',
					'!MODERNIZATION_PLAN.md',
					'!.gitignore',
					'!.git/**',
					'!.claude/**',
					'!tests/**'
				],
				dest: 'build/'
			}
		},

		compress: {
			build: {
				options: {
					pretty: true,                           // Pretty print file sizes when logging.
					archive: '<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'build/',
				src: [ '**/*' ],
				dest: '<%= pkg.name %>/'
			}
		},

	} );

	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );

	// Translations are generated with WP-CLI, the wp.org standard toolchain:
	//   npm run i18n
	// grunt-wp-i18n and grunt-checktextdomain were both unmaintained and could
	// not see strings in JS.
	grunt.registerTask( 'i18n', function () {
		grunt.log.writeln( 'Run "npm run i18n" (requires WP-CLI) to regenerate languages/colorlib-coming-soon-maintenance.pot.' );
	} );

	grunt.registerTask( 'mincss', [  // Minify CSS
		'clean:css',
		'cssmin'
	] );
	// Build task. Run "npm run i18n" first if the strings changed.
	grunt.registerTask( 'build-archive', [
		'clean:init',
		'mincss',
		'copy',
		'compress:build',
		'clean:init'
	] );
};