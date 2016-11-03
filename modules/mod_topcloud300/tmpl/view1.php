<?php //topcloud300 ***  Joomla Module *** Copyright Bob Galway - www.blackdale.com *** License GPL3 - http://www.gnu.org/licenses/

// no direct access
defined('_JEXEC') or die;
// generate cloud
if (!empty($title)) {
    $title2 = '<' . $titletag . '>' . $title . '</' . $titletag . '>';
} else {
    $title2 = "";
}

$getcloud = $helper->getCloud($url, $start1, $length1, $scale, $font,$fontweight, $menuitemno, $modno, $freqData);
$contenttc = $title2 . $getcloud;
