#Joomla 3.x site development -- starlink.ua

*(does not containt core Joomla files)*

## Installation

1. Clone & cd to the new folder
2. Have your Node & npm installed and in working condition
3. `npm install`

## Usage

1. Edit source files in `.src/**`
2. Compile `.src/**` and copy to Joomla folders: `gulp build`
3. Compile only `mod_starlink`:  `gulp modstarlink:compile`
    1. Compile only `mod_starlink`'s css:  `gulp modstarlink:compile:css`
4. Compile & put in `.zip` package ready for installation in Joomla: `gulp modstarlink:build`
5. Delete and rebuild all production files from .src:
   `Gulp cleanBuild`

###svg icons

#### include icon library in the php template:
 
```php
require_once '../media/mod_starlink/images/icons.svg';
```
  
#### insert particular icon in HTML: 

```html
<svg class="icon"><use xlink:href="#iconCancel" /></svg>
```
  
#### currently available icons:

- common icons:
  - `#iconCancel`
  - `#iconCheck`
  - `#iconChevronLeft`
  - `#iconChevronRight`
  - `#iconExpandLess`
  - `#iconExpandMore`
  - `#iconPhone`

- social networks' logos:
  - `#iconFacebook`
  - `#iconGooglePlus`
  - `#iconTwitter`


#### style/theme icon in CSS 
      
```css
/* base/default style */
.icon { 
  height: 2em; 
  width: 2em; 
}

/* add custom themes */
svg.icon--main {
  fill: blue;
}
svg.icon--alert {
  fill: red;
}
```

```html
<svg class="icon icon--main"><use xlink:href="#iconCheck" /></svg>
<svg class="icon icon--alert"><use xlink:href="#iconCheck" /></svg>