Installation
============

#### 1. install/upgrade nvm:  
```bash 
   curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.0/install.sh | bash   
   export NVM_DIR="$HOME/.nvm"  
   [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh"
```   
   - #####check nvm installation:  
```bash 
       command -v nvm    # nvm
       nvm --version     # 0.33.0
```  

#### 2. install/upgrade Node.js:
```bash
   nvm ls            # lists installed versions
   nvm install 7     # install latest v7.x.x
   nvm use 7         # use latest v7.x.x
```
  - ##### check Node.js installation
```bash
       node -v           # 7.5.0 or later
       npm -v            # 4.1.2 or later
```
#### 3. install Apache 2.4.x, PHP 5.6.x, MySQL database 5.5.x

#### 4. clone starlink.ua project ( eg. in `site-joomla/` directory )
```bash
   cd projects && git clone https://github.com/maoizm/site-joomla.git && cd site-joomla
   git checkout develop
   git config --local --add core.autocrlf input
   git config --local --add push.default matching
   git status 
   # On branch develop
   # Your branch is up-to-date with 'origin/develop'.
   # nothing to commit, working tree clean
```
#### 5. unpack Joomla CMS 3.6.5 to `site-joomla/` directory
```bash
   cd site-joomla
   curl -L https://downloads.joomla.org/cms/joomla3/3-6-5/joomla_3-6-5-stable-full_package-zip \
        -o joomla_3-6-5-stable-full_package.zip
   unzip -n joomla_3-6-5-stable-full_package.zip -d .
```
#### 6. create or restore from backup Joomla database
  1. create database, users in phpmyadmin or mysql, assign rights as per Joomla requirements
  2. `cp .src/0_database/file2db.sh . && chmod +x file2db.sh `
  3. add host, port, user name and password (optionally) to `file2db.sh`
  4. `./file2db.sh .20170214_1618_full.sql.gz`  
(файл с последним бекапом базы данных https://www.dropbox.com/s/y9z4xj9v1aqff0d/.20170214_1618_full.sql.gz?dl=0)

#### 7. finish Joomla installation
  * create/copy prepared before Joomla `configuration.php` in `site-joomla/` directory  

 or  
 
  * open your Joomla root url eg. http://your.site/url in browser and finish installation (configuration.php will be made by Joomla installation script )
   
#### 8. install build tools
```bash
   npm i -g gulp-cli yarn
   yarn install                   # change from npm to yarn for locking dependencies & other good stuff
```
  - ##### check correct installation
```bash   
   gulp -v
   # [        ] CLI version 1.2.2
   # [        ] Local version 4.0.0-alpha.2
   
   gulp --tasks    
   # prints long list of tasks
   
   yarn version
   # 0.19.1
```  
#### 9. build
```bash
   gulp clean       # deletes target directories in Joomla to make sure no outdated assets exist which can affect compile
   gulp compile     # compiles postCSS, Sass sources, minifies images, copies from .src to correct Joomla folders
   gulp zip         # creates .zip packages of modules and templates for offline installation to any Joomla instance
```
