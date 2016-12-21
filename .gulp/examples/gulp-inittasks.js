'use strict';

const gulp = require('gulp');
const $ = require('gulp-load-plugins')();

const merge2 = require('merge2');
const upath = require('upath');

const c = {
  env: $.util.env.env || 'development',
  sources: new Map( [
          [ 'mod_services', {
              src: {
                css:    './mod_services/**/!(_)*.css',
                images: './mod_services/**/*.{jpg,png}',
                js:     './mod_services/**/*.js'
              },
              dest: {
                css:    './dist/mod_services',
                images: './dist/mod_services',
                js:     './dist/mod_services'
              }
          } ],
          [ 'mod_calculations', {
              src: {
                css: [
                  './mod_calculations/**/!(_)*.css',
                  './vendors/bootstrap/**/*.css'
                ],
                images: './mod_calculations/**/*.{jpg,png}',
                js: [
                  './mod_calculations/**/*.js',
                  './vendors/bootstrap/**/*.js',
                  '!./vendors/bootstrap/**/*.min.js'
                ]
              },
              dest: {
                css:    './dist/mod_calculations',
                images: './dist/mod_calculations',
                js:     './dist/mod_calculations'
              }
          } ]
  ] )
};


function initTasks ( target = 'css' ) {
  return function() {
    let s = merge2();
    c.sources.forEach( (v, k) => {
      log( k + ': ' + target );
      if ( v.src[target] ) {
        s.add(
          gulp.src( v.src[target] )
          .pipe( $.filenames( 'Task:' + k ) )
          .pipe( gulp.dest( v.dest[target]) )
          .pipe( $.filenames( 'Task:dest:' + k ) )
          .on('end',
              () => {
                  console.log( `task ${k}:${target}` );
                  let z = $.filenames.get( 'Task:' + k )
                    .map(
                        (e,i) =>
                            upath.resolve(e) + ' | ' +
                            upath.resolve( $.filenames.get( 'Task:dest:' + k )[i] )
                    );
                  console.log(
                    z.sort()
                    .reduce((s1, s2) => `${s1}    ${s2}\n`, '')
                  );
              }
          )
        );
      }
    });
    return s;
  }
}

module.exports = initTasks('css');