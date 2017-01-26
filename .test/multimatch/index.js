/**
 * Created by mao on 26.01.2017.
 */

const
    multimatch = require('multimatch'),
    util = require('util'),
    loggy = require('../../.gulp/helpers').loggy,
s = require('../../.gulp/helpers').stringly;



loggy(multimatch(['unicorn', 'cake', 'rainbows'], ['*', '!cake']));
loggy(multimatch(
    multimatch(['src/vendor/bs.js', 'src/vendorx/bs.js', 'test/a.js', 'src/a.js', 'src/a/b/c/d.js','src/vendor/a.js.css'], ['src/**/*.js']),
    ['**', '!*src/vendor'])
);
