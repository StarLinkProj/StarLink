<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
global $sh_LANG;
$sefConfig =& Sh404sefFactory::getConfig();
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin($lang, $shLangName, $shLangIso, $option);
if ($dosef == false)
{
	return;
}

shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('lang');
shRemoveFromGETVarsList('option');
shRemoveFromGETVarsList('view');
isset($task) || ($task = null);
isset($Itemid) || ($Itemid = null);
$title[] = getMenuTitle($option, $task, $Itemid, null, $shLangName);
$string = '';
if ($dosef)
{
	$string = shFinalizePlugin($string, $title, $shAppendString, $shItemidString, isset($limit) ? @$limit : null, isset($limitstart) ? @$limitstart : null, isset($shLangName) ? @$shLangName : null);
}