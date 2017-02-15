/**
 * Created by mao on 13.02.2017.
 */

const argv = require('minimist')(process.argv.slice(2));

module.exports = {
  production: argv.production
};