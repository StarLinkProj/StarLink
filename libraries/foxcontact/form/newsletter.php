<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.log');

class FoxFormNewsletter
{
	private static $enabled = array();
	
	public static function isEnable($extension)
	{
		if (!isset(self::$enabled[$extension]))
		{
			self::$enabled[$extension] = self::isInstalled($extension) && self::config($extension);
		}
		
		return self::$enabled[$extension];
	}
	
	
	private static function isInstalled($extension)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('extension_id'));
		$query->from($db->quoteName('#__extensions'));
		$query->where($db->quoteName('name') . ' = ' . $db->quote($extension));
		$db->setQuery($query);
		return $db->loadResult();
	}
	
	
	private static function config($extension)
	{
		switch ($extension)
		{
			case 'acymailing':
				$enabled = self::configAcyMailing();
				break;
			case 'jnews':
				$enabled = self::configJNews();
				break;
			default:
				$enabled = false;
				break;
		}
		
		return $enabled;
	}
	
	
	private static function configAcyMailing()
	{
		return (bool) @(include_once JPATH_ADMINISTRATOR . '/components/com_acymailing/helpers/helper.php');
	}
	
	
	private static function configJNews()
	{
		$enable = true;
		defined('JNEWS_JPATH_ROOT') or define('JNEWS_JPATH_ROOT', JPATH_ROOT);
		$enable &= (bool) @(include_once JPATH_ROOT . '/components/com_jnews/defines.php');
		if (defined('JNEWS_OPTION'))
		{
			$enable &= (bool) @(include_once JNEWS_JPATH_ROOT . '/administrator/components/' . JNEWS_OPTION . '/classes/class.jnews.php');
		}
		else
		{
			$enable = false;
		}
		
		return $enable;
	}
	
	
	public static function load($extension, $filters = array())
	{
		switch ($extension)
		{
			case 'acymailing':
				return self::loadAcyMailing($filters);
			case 'jnews':
				return self::loadJNews($filters);
			default:
				return null;
		}
	
	}
	
	
	private static function loadAcyMailing($filters)
	{
		return FoxFormNewsletter::query('acymailing', 'listid', 'name', '#__acymailing_list', 'ordering', $filters);
	}
	
	
	private static function loadJNews($filters)
	{
		return FoxFormNewsletter::query('jnews', 'id', 'list_name', '#__jnews_lists', 'id', $filters);
	}
	
	
	private static function query($extension, $key, $value, $table, $order, $filters)
	{
		if (!self::isEnable($extension))
		{
			return null;
		}
		
		$options = array();
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName($key) . ',' . $db->quoteName($value));
		$query->from($db->quoteName($table));
		$query->where($db->quoteName('published') . ' = ' . $db->quote('1'));
		$query->order($db->quoteName($order) . ' ASC');
		if (count($filters) > 0)
		{
			foreach ($filters as $k => $filter)
			{
				$filters[$k] = $db->quote($filter);
			}
			
			$query->where($db->quoteName($key) . ' IN (' . implode(',', $filters) . ')');
		}
		
		$db->setQuery($query);
		$items = $db->loadObjectlist() or $items = new stdClass();
		if (count($items) === 0)
		{
			return null;
		}
		
		foreach ($items as $item)
		{
			$options[] = array('value' => $item->{$key}, 'label' => $item->{$value});
		}
		
		return array('type' => $extension, 'name' => JText::_("COM_FOXCONTACT_ITEM_NEWSLETTER_{$extension}_LBL"), 'options' => $options);
	}

}