<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxStructManager
{
	private static $version = null;
	
	public static function check($json)
	{
		$struct = json_decode($json, true);
		$current = isset($struct['version']) ? $struct['version'] : self::getVersion();
		foreach (self::getUpgradeMethodMap() as $ver => $method)
		{
			if (version_compare($ver, $current, '>='))
			{
				$struct = forward_static_call(array(__CLASS__, $method), $struct);
			}
		
		}
		
		$struct['version'] = self::getVersion();
		return $struct;
	}
	
	
	private static function getUpgradeMethodMap()
	{
		$map = array();
		$methods = array_filter(get_class_methods(__CLASS__), function ($method)
		{
			return substr($method, 0, 2) === 'up';
		});
		foreach ($methods as $method)
		{
			$map[str_replace('_', '.', substr($method, 2))] = $method;
		}
		
		uksort($map, 'version_compare');
		return $map;
	}
	
	
	public static function up3_5_0($struct)
	{
		self::fixItems($struct, array('text_area'), function (&$item)
		{
			if ($item['height']['unit'] === 'inherited')
			{
				$item['height']['unit'] = 'auto';
			}
		
		});
		return $struct;
	}
	
	
	public static function up3_5_4($struct)
	{
		self::fixItems($struct, array('dropdown', 'radio'), function (&$item)
		{
			foreach ($item['options'] as $i => $option)
			{
				if (is_string($option))
				{
					$item['options'][$i] = array('text' => $option, 'to' => '');
				}
			
			}
		
		});
		return $struct;
	}
	
	
	private static function fixItems(&$struct, $types, $function)
	{
		foreach ($struct['rows'] as &$row)
		{
			foreach ($row['columns'] as &$column)
			{
				foreach ($column['items'] as &$item)
				{
					if (in_array($item['type'], $types))
					{
						$function($item);
					}
				
				}
			
			}
		
		}
	
	}
	
	
	public static function getVersion()
	{
		if (is_null(self::$version))
		{
			$xml = new SimpleXMLElement(JPATH_ADMINISTRATOR . '/components/com_foxcontact/foxcontact.xml', 0, true);
			self::$version = (string) $xml->version;
		}
		
		return self::$version;
	}

}