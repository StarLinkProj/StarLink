<?php //topcloud300 ***  Joomla Module *** Copyright Bob Galway - www.blackdale.com *** License GPL3 - http://www.gnu.org/licenses/

// no direct access
defined('_JEXEC') or die;
//Find site base URL
$url = JURI::base();
$css = "";
//collect parameters
$phrase = $params->get('phrase');
$shuffle = $params->get('shuffle');
$lang = $params->get('lang');
$all_lang = $params->get('all_lang');
$keycolour = $params->get('keycolour');
$modno = $params->get('modno');
if ($modno == 0) {
    $modno = "_TC" . ($module->id);
}
$display = $params->get('display');
$menuitemno = JRequest::getInt('Itemid');
$pageselect = $params->get('pageselect');
if ($pageselect == '2') {
    $menuitemno = $params->get('menuitem');
}
$wordmax = $params->get('wordmax');
$wordmin = $params->get('wordmin');
$xchars = $params->get('xchars');
$title = $params->get('title');
$titlealign = $params->get('titlealign');
$titletag = $params->get('titletag');
$titlecolour =  $params->get('titlecolour');
$exclude = "ROOT,".$params->get('exclude');
$include = $params->get('include');
$exclude .= ",xxxxxx,";
$tfont = $params->get('tfont');
$tfontweight = $params->get('tfontweight');
$scale = $params->get('scale');
$font = $params->get('font');
$fontweight = $params->get('fontweight');
$start1 = intval($params->get('start'));
$length1 = intval(trim($params->get('length'), "-"));
$graphics = $params->get('graphics');
$keywords = $params->get('keywords');
$articles = $params->get('articles');
$weblinks = $params->get('weblinks');
$contacts = $params->get('contacts');
$categories = $params->get('categories');
$sections = $params->get('sections');
$newsfeeds = $params->get('newsfeeds');
$tags = $params->get('tags');
$logreq = $params->get('logreq');

//links/tags
$customcolour=$params->get('customcolour');
if($customcolour==1){
$activebg = $params->get('activebg').' !important';
$active =$params->get('active').' !important';
$hover = $params->get('hover').' !important';
$hoverbg = $params->get('hoverbg').' !important';
$link = $params->get('link').' !important';
$visited = $params->get('visited').' !important';}

//general module properties
$marginleftmodule = $params->get('margin-leftmodule');
$paddingleft = $params->get('paddingleft');
$paddingright = $params->get('paddingright');
$paddingtop = $params->get('paddingtop');
$paddingbottom = $params->get('paddingbottom');
$margintop = $params->get('margin-top');
$marginbottom = $params->get('margin-bottom');
$width = $params->get('width');
$widthunit = $params->get('widthunit');
$ctag= $params->get('ctag');
$bgpattern = $params->get('bgpattern');
if($bgpattern==-1){$bgpattern="transparent.png";}
$colour2 =  $params->get('colour2');
$colour1 = $params->get('colour1');
$trans1 = $params->get('trans1');
$trans2 = $params->get('trans2');
if ($trans1 == 2) {
    $colour1 = "transparent";
}
if ($trans2 == 2) {
    $colour2 = "transparent";
}

$bordercol = $params->get('bordercol');
$bordersz = $params->get('bordersz');
$shadcol = $params->get('shadcol');
$shadsz = $params->get('shadsz');
$querytext = "";
