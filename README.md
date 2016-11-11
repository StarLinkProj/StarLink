#Joomla 3.x site development -- starlink.ua

does not containt core Joomla files

##svg icons

### include icon library in the php template:
 
```php
require_once '../media/mod_starlink/images/icons.svg';
```
  
### insert particular icon in HTML: 

```html
<svg class="icon"><use xlink:href="#iconCancel" /></svg>
```
  
### currently available icons:

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


### style/theme icon in CSS 
      
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