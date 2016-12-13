const paths = (baseDir = '.') => ({
  src:  [ `${baseDir}/.src/mod_starlink*/**/*.css`, `${baseDir}/.src/templates/**/*.css` ],
  dest:   `${baseDir}/.build/compiled_css`
});
const defaultPaths = paths();

export {paths};
export default defaultPaths;
