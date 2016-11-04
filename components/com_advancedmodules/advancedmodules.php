<?php
/**
 * @package         Advanced Module Manager
 * @version         6.2.10
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2016 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

$app = JFactory::getApplication();

if (!JFactory::getUser()->authorise('module.edit.frontend', 'com_modules.module.' . $app->input->get('id'))
	&& !JFactory::getUser()->authorise('module.edit.frontend', 'com_modules')
)
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once JPATH_LIBRARIES . '/regularlabs/helpers/functions.php';

RLFunctions::loadLanguage('com_modules', JPATH_ADMINISTRATOR);
RLFunctions::loadLanguage('com_advancedmodules');

jimport('joomla.filesystem.file');

// return if Regular Labs Library plugin is not installed
if (
	!JFile::exists(JPATH_PLUGINS . '/system/regularlabs/regularlabs.xml')
	|| !JFile::exists(JPATH_LIBRARIES . '/regularlabs/regularlabs.xml')
)
{
	$msg = JText::_('AMM_REGULAR_LABS_LIBRARY_NOT_INSTALLED')
		. ' ' . JText::sprintf('AMM_EXTENSION_CAN_NOT_FUNCTION', JText::_('COM_ADVANCEDMODULES'));
	$app->enqueueMessage($msg, 'error');

	return;
}

// give notice if Regular Labs Library plugin is not enabled
$regularlabs = JPluginHelper::getPlugin('system', 'regularlabs');
if (!isset($regularlabs->name))
{
	$msg = JText::_('AMM_REGULAR_LABS_LIBRARY_NOT_ENABLED')
		. ' ' . JText::sprintf('AMM_EXTENSION_CAN_NOT_FUNCTION', JText::_('COM_ADVANCEDMODULES'));
	$app->enqueueMessage($msg, 'notice');
}

// load the Regular Labs Library language file
RLFunctions::loadLanguage('plg_system_regularlabs');
// Load admin main core language strings
RLFunctions::loadLanguage('', JPATH_ADMINISTRATOR);

// Tell the browser not to cache this page.
$app->setHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT', true);

$config = array();
if ($app->input->get('task') === 'module.orderPosition')
{
	$config['base_path'] = JPATH_COMPONENT_ADMINISTRATOR;
}

$controller = JControllerLegacy::getInstance('AdvancedModules', $config);
$controller->execute($app->input->get('task'));
$controller->redirect();
