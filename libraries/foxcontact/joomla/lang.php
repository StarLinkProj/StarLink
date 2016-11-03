<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxJoomlaLang
{
	
	public static function load($site = false, $admin = false)
	{
		static $site_loaded = false, $admin_loaded = false;
		$lang = JFactory::getLanguage();
		if (!$site_loaded && $site)
		{
			self::loadPathOnLang($lang, JPATH_SITE . '/components/com_foxcontact');
			$site_loaded = true;
		}
		
		if (!$admin_loaded && $admin)
		{
			self::loadPathOnLang($lang, JPATH_ADMINISTRATOR . '/components/com_foxcontact');
			$admin_loaded = true;
		}
	
	}
	
	
	private static function loadPathOnLang($lang, $path)
	{
		$lang->load('com_foxcontact', $path, $lang->getDefault(), true);
		$lang->load('com_foxcontact', $path, null, true);
	}

}