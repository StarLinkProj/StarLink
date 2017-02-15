/**
 * Created by mao on 30.01.2017.
 */


/**
 * ContentModule: creates configuration object for further processing in gulp workflow
 *
 * @param modName   - name of module
 * @param base      - path of module
 * @param srcRoot   - root directory of all modules' sources
 * @param destRoot  - root directory of all modules' build location
 * @param assets    - optional next assests ( {name, base, srcRoot, destRoot, ...assets} )
 * @constructor     - populates a.src and a.dest for each asset and return the list of assets
 */


module.exports = function ContentModule(
  modName,
  { base = '/' + modName, srcRoot=false, destRoot=false } = {},
  ...assets )

{
  /*  to prevent occasional delete of everything :)  */
  if(!srcRoot || !destRoot) throw "ContentModule: 'srcRoot' and 'destRoot are mandatory!";

  this.srcRoot = srcRoot;
  this.destRoot = destRoot;
  this.name = modName;
  //this.base = base;

  for (let a of assets) {
    let {
      name = false,                               // asset name
      src = false,                                // source files glob
      dest = `${destRoot}${base}${destDir}`,      // destination path
      srcDir = '',                                // directory part of source path (makes sense if src is missing
      destDir = srcDir,                           // directory part of destination path
      srcFiles = [ '/**/*.?*' ],                  // glob for source filenames
      srcExcludeFiles = []                        // glob for exclusions from source filenames
    } = a;

    if (!name) throw "ContentModule: Task method 'name' is missing";

    /* if source path is given, we just use it, otherwise make it up from srcRoot, srcDir, srcFiles etc. */
    if (!src) {

      /* convert source files glob to array (node-glob format) and prepend source root path to each file glob */
      if (typeof srcFiles === 'string')
        srcFiles = [srcFiles];
      srcFiles = srcFiles.map(i => `${srcRoot}${base}${srcDir}${i}`);

      /* convert exclusion files glob to array (node-glob format) and prepend source root path */
      if (typeof srcExcludeFiles === 'string')
        srcExcludeFiles = [srcExcludeFiles];
      srcExcludeFiles = srcExcludeFiles.map(i => `!${srcRoot}${base}${srcDir}${i}`);

      src = srcFiles.concat(srcExcludeFiles);
    }

    this[a.name] = a;
  }
};
