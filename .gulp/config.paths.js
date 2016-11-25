const paths = (baseDir = '.') => ({
  example: {
    src:  [ `${baseDir}/.src/mod_starlink*/**/*.css`, `${baseDir}/.src/templates/**/*.css` ],
    dest:   `${baseDir}/.build/compiled_css`
  },
  postcss: {
    mod_starlink: {
      src: [
        './.src/mod_starlink/media/css/styles.css',
        './.src/mod_starlink/media/css/bootstrap.css',
        './.src/mod_starlink/media/css/font-default.css',
        './.src/bassplate/css/bass.pretty.css'
      ],
      build: './.build/mod_starlink/media/css'
    },
    mod_calc: {
      src:   './.src/mod_starlink_calculator_outsourcing/media/css/*.css',
      build: './.build/mod_starlink_calculator_outsourcing/media/css'
    },
    mod_services: {
      src:   './.src/mod_starlink_services/media/css/*.css',
      build: './.build/mod_starlink_services/media/css'
    },
    templates: {
      src:   './.src/templates/**/*.css',
      build: './.build/templates'
    }
  },
  js: {
    src:    './.src/mod_starlink*/media/js/**/*.*',
    build:  './.build'
  },
  images: {
    src:    './.src/mod_starlink*/media/images/**/*.*',
    build:  './.build'
  },
  fonts: {
    src:    './.src/mod_starlink*/media/fonts/**/*.*',
    build:  './.build'
  },
  other: {
    src: [
      './.src/mod_starlink*/**/*.*',
      '!./**/*.jpg', '!./**/*.svg', '!./**/*.png', '!./**/*.ico',
      '!./**/*.css', '!./**/*.pcss',
      '!./**/*.js',
      '!./.src/mod_starlink*/media/fonts/**/*.*'
    ],
    build: './.build'
  },
  modules: {
    build:  './.build/mod_starlink*/media/**/*.*',
    deploy: './media',
  },
  templates: {
    build:  './.build/templates/**/*.*',
    deploy: './templates'
  }
});
const defaultPaths = paths();

export {paths};
export default defaultPaths;
