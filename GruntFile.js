module.exports = function(grunt) {
    'use strict';
    
    // Load npm tasks beginning with 'grunt-'
    require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );
    
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        dirs: {
            css: "assets/css",
            js: "assets/js",
            scss: "assets/scss"
        },
        watch: {
            options: {
                spawn: false // Makes watch run A LOT faster, and also lets you pass variables to the grunt tasks being called
            },
            js: {
                files: ['<%= dirs.js %>/src/*.js','components/**/*.js'],
                tasks: ['concat:js','uglify']
            },
            scss: {
                files: ['<%= dirs.scss %>/*.scss','components/**/*.scss'],
                tasks: ['copy:scss','compass','concat:css']
            }
        },
        compass: {
            dist: {
                options: {
                    sassDir: '<%= dirs.scss %>',
                    cssDir: '<%= dirs.css %>/src',
                    environment: 'production',
                    raw: 'preferred_syntax = :scss\n', // Use `raw` since it's not directly available
                    outputStyle: 'compressed'
                }
            }
        },
        concat: {
            css: {
                options: {
                    separator: ''
                },
                src: ['<%= dirs.css %>/src/*.css'],
                dest: '<%= dirs.css %>/dist/amarkal-ui.min.css'
            },
            js: {
                options: {
                    banner: '(function($,global){',
                    footer: '})(jQuery, window);',
                    separator: "\n"
                },
                src: [
                    '<%= dirs.js %>/src/core.js',
                    '<%= dirs.js %>/src/abstractComponent.js',
                    '<%= dirs.js %>/src/jquery.amarkalUIComponent.js',
                    'components/**/*.js'
                ],
                dest: '<%= dirs.js %>/dist/amarkal-ui.min.js'
            }
        },
        copy: {
            scss: {
                files: [
                    {   // Copy UI style files to the js dir
                        expand: true,
                        cwd: 'components/',
                        src: ['**/*.scss'],
                        dest: '<%= dirs.scss %>/', 
                        filter: 'isFile',
                        rename: function(dest, src) {
                            return dest + src.split("/")[src.split("/").length-2] + '.scss';
                        }
                    }
                ]
            }
        },
        uglify: {
            main: {
                options: {
                    banner: ''
                },
                files: {
                    '<%= dirs.js %>/dist/amarkal-ui.min.js': ['<%= dirs.js %>/dist/amarkal-ui.min.js']
                }
            }
        }
    });
    
    // On watch events configure copy tasks to only run on changed file
    grunt.event.on('watch', function(action, filepath) {
        grunt.config('copy.scss.files.0.cwd', '');
        grunt.config('copy.scss.files.0.src', [filepath]);
    });
};