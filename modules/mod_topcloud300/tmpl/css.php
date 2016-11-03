<?php //topcloud300 ***  Joomla Module *** Copyright Bob Galway - www.blackdale.com *** License GPL3 - http://www.gnu.org/licenses/

// no direct access
defined('_JEXEC') or die;

$css = "
    /* TopCloud300 Starts */
    a.cloud".$modno.":link{text-decoration:none !important;color:".$link.";}

    a.cloud".$modno.":visited{text-decoration:none !important;color:".$visited.";}
    a.cloud".$modno.":hover{text-decoration:none !important;color:".$hover.";background:".$hoverbg.";}
    a.cloud".$modno.":active{text-decoration:none !important;color:".$active.";background:".$activebg.";}

    #holder".$modno."{width:".$width.$widthunit.";";
if (!empty($margintop)) {
    $css .= "margin-top:" . $margintop . "px;";
}
if (!empty($marginbottom)) {
    $css .= "margin-bottom:" . $marginbottom . "px;";
}
if (!empty($marginleftmodule)) {
    $css .= "margin-left:" . $marginleftmodule . "px;";
}
if (!empty($margintop)) {
    $css .= "margin-top:" . $margintop . "px;";
}
if (!empty($paddingtop)) {
    $css .= "padding-top:" . $paddingtop . "px;";
}
if (!empty($paddingbottom)) {
    $css .= "padding-bottom:" . $paddingtop . "px;";
}
if (!empty($paddingleft)) {
    $css .= "padding-left:" . $paddingleft . "px;";
}
if (!empty($paddingright)) {
    $css .= "padding-right:" . $paddingright . "px;";
}
if (!empty($colour2)) {
    $css .= "background-color:" . $colour2 . ";";
}
$css.="}
    ";
if(!empty($title)) {$css.="#inner".$modno." ".$titletag."{font-family:".$tfont.";color:".$titlecolour.";font-weight:".$tfontweight.";text-align:".$titlealign.";}";}

if($graphics==1){
$css.="#buffer".$modno."{padding:5px;}
    ";

$css.="#inner".$modno."{background:".$colour1." url(".$url."/modules/mod_topcloud300/tmpl/images/backgrounds/".$bgpattern.");padding:5px;border:".$bordersz."px solid ".$bordercol.";border-radius:".(ceil($bordersz*1.4))."px;box-shadow:0 0 ".$shadsz."px ".$shadcol.";}";}
$css.="
    /* TopCloud300 Ends */
    ";

$doc->addStyleDeclaration($css);
if(!empty($ctag)){$doc->addCustomTag($ctag);}
