/**
 * Created by mao on 11.02.2017.
 */

const del = require('del');

module.exports = (gulp, plugins) =>
  del([ '_build/css/{styles,print,offline}.*' ]);
