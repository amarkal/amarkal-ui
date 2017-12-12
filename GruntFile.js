module.exports = function(grunt) {
    'use strict';
    
    // Load grunt plugins 'just-in-time'
    require('jit-grunt')(grunt);
    
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
                tasks: ['uglify', 'jshint']
            },
            scss: {
                files: ['<%= dirs.scss %>/*.scss','components/**/*.scss'],
                tasks: ['copy:scss','compass','concat:css']
            }
        },
        jshint: {
            options: {
                jshintrc: true
            },
            all: ['<%= dirs.js %>/src/*.js','components/**/*.js']
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
                    sourceMap: true,
                    wrap: 'Amarkal'
                },
                files: {
                    '<%= dirs.js %>/dist/amarkal-ui.min.js': [
                        '<%= dirs.js %>/src/core.js',
                        '<%= dirs.js %>/src/abstractComponent.js',
                        '<%= dirs.js %>/src/visibilityManager.js',
                        '<%= dirs.js %>/src/form.js',
                        '<%= dirs.js %>/src/jquery.amarkalUIComponent.js',
                        '<%= dirs.js %>/src/jquery.amarkalUIForm.js',
                        'components/**/*.js'
                    ]
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