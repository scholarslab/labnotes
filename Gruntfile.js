'use strict';

module.exports = function(grunt) {

  // load all grunt tasks
  require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

  var paths = {
    js: './javascripts',
    images: './images/',
    sass: './_sass/'
  };

   var devConfig = {
     env: grunt.file.readJSON('.configs.json')
    };

  grunt.initConfig({

    devconfig: devConfig,
    //env : {
      //production : {
        //src : ".env"
      //}
    //},

    imagemin: {
      dist: {
        options: {
          optimizationLevel: 7,
          progressive: true
        },
        files: [{
          expand: true,
          cwd: paths.images,
          src: '**/*',
          dest: paths.images
        }]
      }
    },

    rsync: {
      options: {
        args: ["--verbose"],
        recursive: true,
        exclude: ['.git*', 'bower_components', 'node_modules', '.sass-cache', 'Gruntfile.js', 'bower.json', 'package.json', '.DS_Store', 'README.md', 'config.rb', '.jshintrc', '.editorconfig', '.ruby*']
      },
      production: {
        options: {
          src: "./",
          dest: "<%= devconfig.env.prod.dest %>",
          host: "<%= devconfig.env.prod.host %>"
        }
      },

    }

  });

  grunt.registerTask('default', ['imagemin']);
  grunt.registerTask('deploy', ['rsync:production']);

};
