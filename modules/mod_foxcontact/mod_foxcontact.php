<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.lang');
jimport('foxcontact.form.model');
jimport('foxcontact.form.render');
if (isset($GLOBALS['foxcontact_mid_' . $module->id]))
{
	return;
}
else
{
	$GLOBALS['foxcontact_mid_' . $module->id] = true;
}

$cache = JFactory::getCache('com_modules', '');
$cache->setCaching(false);
$cache = @JFactory::getCache('com_content', 'view');
$cache->setCaching(false);
$body = JFactory::getApplication()->getBody();
if (!empty($body))
{
	echo JText::_('COM_FOXCONTACT_ADDITIONAL_SETTINGS_REQUIRED') . ' <a href="http://www.fox.ra.it/forum/22-how-to/10274-nested-modules.html">' . JText::_('COM_FOXCONTACT_READ_MORE') . '</a>';
	return;
}

if (isset($scope) && $scope == 'com_content')
{
	echo '<!--{emailcloak=off}-->';
}

FoxJoomlaLang::load(true, false);
$form = FoxFormModel::getFormFromModule($module->id, $params);
FoxFormRender::start('form', $form);