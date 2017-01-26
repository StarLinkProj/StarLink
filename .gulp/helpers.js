'use strict';
const upath = require('upath');
const util = require('util');
const gulp = require('gulp');
const $ = require('gulp-load-plugins')();
const c = require('../config.gulp.js');





const zipHelper = key => {
  const s = c.sources.get(key);
  return function() {
    return gulp.src(s.src.zip)
    .pipe($.filenames(key + ':zip:source'))
    .pipe($.zip(s.dest.zipName + '.zip'))
    .pipe(gulp.dest(s.dest.zip))
    .pipe($.filenames(key + ':zip:dest'))
    .on('end', logPipeline(key, 'zip'));
  }
};
exports.zipHelper = zipHelper;





const logPipeline = (module, task) => {
  return function () {
    console.log(
            $.filenames.get(`${module}:${task}:source`, 'full')
            .map(v => `${module}:${task}:source: ${upath.normalize(v)}`)
            .reduce( (acc, curr) => `${acc}${curr}\n`, '' )
    );
    console.log(
            $.filenames.get(`${module}:${task}:dest`, 'full')
            .map(v => `${module}:${task}:dest:   ${upath.normalize(v)}`)
            .reduce( (acc, curr) => `${acc}${curr}\n`, '' )
    );
  }
};
exports.logPipeline = logPipeline;





exports.stringly = o => JSON.stringify(o, null, 2);



/**
 *  loggy: pretty print any object, array etc and returns
 *  prettified string to caller
 *
 *  Usage:
 *      loggy(o);                  // console.log(o);
 *      loggy(o, {fn: util.log});  // util.log(o);
 *      let x = loggy( o, {fn: util.log} );
 *      let x = loggy( o, {fn: null} );
 *
 * */
exports.loggy = ( o, options = {} ) => {
    if (Object.keys(options).length == 0) {
        options = {
            showHidden: false,
            depth:      null,
            colors:     true,
            fn:         console.log
        };
    }
    else if ( !('fn' in options) ) {
        options.fn = console.log;
    };

    if ( typeof options.fn === 'function' )  {
        options.fn(util.inspect( o, options ));
    };

    return JSON.stringify( o, null, 2 );
};
