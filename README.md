#Joomla 3.x site development -- starlink.ua

does not containt core Joomla files

##svg icons
- include in the template:
 
  `require_once '../media/mod_starlink/images/icons.svg';`
  
- insert icon: 

  `<svg class="icon"> <use xlink:href="#iconCancel" /> </svg>`
  
- style icon: 

  `.icon    { height: 50px; width: 50px; }`
  
  `svg.icon { fill: blue; }`
      
