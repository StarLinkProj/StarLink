<?php //topcloud300 ***  Joomla Module *** Copyright Bob Galway - www.blackdale.com *** License GPL3 - http://www.gnu.org/licenses/

// no direct access
defined('_JEXEC') or die;

// Retrieve selected words
$user = JFactory::getUser();
$cond='';
if (($user->guest)&&($logreq==1)) {$cond='AND (`access`=1)';}

$db = JFactory::getDBO();
if ($keywords == 1) {
    $db->setQuery('SELECT * FROM `#__content` WHERE `state`=1 AND (`language`="' . $lang .
        '" OR `language`="' . $all_lang . '") '.$cond);
    $contents = $db->loadObjectList();
    $i = 0;
    while (!empty($contents[$i])) {
        $querytext .= ($contents[$i]->metakey) . ',';
        $i++;
    }
}
if ($articles == 1) {
    $db->setQuery('SELECT * FROM `#__content` WHERE `state`=1 AND (`language`="' . $lang .
        '" OR `language`="' . $all_lang . '") '.$cond);
    $contents = $db->loadObjectList();
    $i = 0;
    while (!empty($contents[$i])) {
        $querytext .= ($contents[$i]->title) . ',';
        $i++;
    }
}
if ($weblinks == 1) {
    $db->setQuery('SELECT * FROM `#__weblinks` WHERE `state`=1 AND (`language`="' .
        $lang . '" OR `language`="' . $all_lang . '") '.$cond);
    $contents = $db->loadObjectList();
    $i = 0;
    while (!empty($contents[$i])) {
        $querytext .= ($contents[$i]->title) . ',';
        $i++;
    }
}
if ($contacts == 1) {
    $db->setQuery('SELECT * FROM `#__contact_details` WHERE `published`=1  AND (`language`="' .
        $lang . '" OR `language`="' . $all_lang . '") '.$cond);
    $contents = $db->loadObjectList();
    $i = 0;
    while (!empty($contents[$i])) {
        $querytext .= ($contents[$i]->name) . ',';
        $i++;
    }
}
if ($categories == 1) {
    $db->setQuery('SELECT * FROM `#__categories` WHERE `published`=1 AND (`language`="' .
        $lang . '" OR `language`="' . $all_lang . '") '.$cond);
    $contents = $db->loadObjectList();
    $i = 0;
    while (!empty($contents[$i])) {
        $querytext .= ($contents[$i]->title) . ',';
        $i++;
    }
}
if ($newsfeeds == 1) {
    $db->setQuery('SELECT * FROM `#__newsfeeds` WHERE `published`=1 AND (`language`="' .
        $lang . '" OR `language`="' . $all_lang . '") '.$cond);
    $contents = $db->loadObjectList();
    $i = 0;
    while (!empty($contents[$i])) {
        $querytext .= ($contents[$i]->name) . ',';
        $i++;
    }
}
if ($tags == 1) {
    $db->setQuery('SELECT * FROM `#__tags` WHERE `published`=1 AND (`language`="' .
        $lang . '" OR `language`="' . $all_lang . '") '.$cond);
    $contents = $db->loadObjectList();
    $i = 0;
    while (!empty($contents[$i])) {
        $querytext .= ($contents[$i]->alias) . ',';
        $i++;
    }
}

$querytext .= $include;
