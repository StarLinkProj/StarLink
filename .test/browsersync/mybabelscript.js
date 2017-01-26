const loggy=require('../../.gulp/helpers').loggy;
let cfg = require('./config');
cfg = Object.assign(cfg, { browserSync: { server:  { baseDir: '.dist' }, files:   ['.dist/**/*.pcss'], browser: 'chrome', notify:  false }, postcssConfig: [ require('postcss-import'), require('postcss-nesting'), require('postcss-custom-properties') ] });   
cfg.styleMod = Object.assign(cfg.styleMod, { styles: { options: { reload: false, postcss: cfg.postcssConfig } } } );

cfg.styleMod.styles = Object.assign(cfg.styleMod.styles, { options: { reload: false, postcss: cfg.styleMod.styles.src } } );