<?php
/**
 * Created by PhpStorm.
 * User: mao
 * Date: 01.11.2016
 * Time: 15:31
 */

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
//require_once dirname(__FILE__) . '/helper.php';

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

//$title = modStarlinkServicesHelper::getTitle($params);
require JModuleHelper::getLayoutPath('mod_starlink_map');