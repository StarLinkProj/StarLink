<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.form.form');
jimport('foxcontact.joomla.comp');
jimport('foxcontact.struct.manager');

class FoxFormModel
{
	private static $forms = array();
	
	public static function getFormByUid($uid)
	{
		$lower_uid = strtolower($uid);
		if (!isset(self::$forms[$lower_uid]))
		{
			self::$forms[$lower_uid] = self::loadFormByUid($lower_uid);
		}
		
		return self::$forms[$lower_uid];
	}
	
	
	private static function loadFormByUid($uid)
	{
		switch (substr($uid, 0, 1))
		{
			case 'c':
				return self::loadFormFromMenu(intval(substr($uid, 1)));
			case 'm':
				return self::loadFormFromModule(intval(substr($uid, 1)));
			default:
				throw new RuntimeException("Invalid uid: '{$uid}'.");
		}
	
	}
	
	
	private static function loadFormFromMenu($id)
	{
		$menu = JFactory::getApplication()->getMenu()->getItem($id);
		return new FoxFormForm('component', $menu->id, $menu->params, FoxStructManager::getVersion());
	}
	
	
	private static function loadFormFromModule($id)
	{
		$module = self::loadModule($id);
		return new FoxFormForm('module', $module->id, FoxJoomlaComp::newJRegistry($module->params), FoxStructManager::getVersion());
	}
	
	
	private static function loadModule($id)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('id') . ',' . $db->quoteName('params'));
		$query->from($db->quoteName('#__modules'));
		$query->where($db->quoteName('id') . ' = ' . $db->quote($id));
		$query->where($db->quoteName('module') . ' = ' . $db->quote('mod_foxcontact'));
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	
	public static function getFormFromModule($id, $params)
	{
		$lower_uid = strtolower("m{$id}");
		if (!isset(self::$forms[$lower_uid]))
		{
			self::$forms[$lower_uid] = new FoxFormForm('module', $id, $params, FoxStructManager::getVersion());
		}
		
		return self::$forms[$lower_uid];
	}

}