/**
 * Created by mao on 31.01.2017.
 */

/*@  Debug things */
const loggy = require('../../.gulp/helpers.js').loggy;
const stringly = require('../../.gulp/helpers.js').stringly;

const gulp = require('gulp');
const plugins = require('gulp-load-plugins')();


/**
 * Get a task. This function just gets a task from the tasks directory, and
 * sets some sane default options used on all tasks such as the error handler
 * and the `rev` option.
 *
 * @param {string} name The name of the task.
 * @param {object} [options] Options to pass to the task.
 * @returns {function} The task!
 */

module.exports = function getTask(name, options) {
  if (typeof options !== 'object') {
    options = {};
  }

  return require('./.tasks/' + name)(gulp, plugins, options);
};
