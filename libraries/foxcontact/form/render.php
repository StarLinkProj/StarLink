<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.elem');
jimport('foxcontact.html.encoder');

class FoxFormRender
{
	private static $current = null, $form = null;
	
	public static function listFormVariables($names = '')
	{
		$variables = array();
		foreach (explode(' ', ucwords(str_replace(',', ' ', $names))) as $name)
		{
			$variables[] = self::$form->{"get{$name}"}();
		}
		
		$variables[] = self::$current;
		$variables[] = self::$form;
		return $variables;
	}
	
	
	public static function start($name, $data)
	{
		self::$form = $data;
		self::disablePageCache();
		self::$form->onBeforeRender();
		echo self::render($name);
		self::$form->onAfterRender();
		self::$form = null;
	}
	
	
	private static function disablePageCache()
	{
		foreach (JEventDispatcher::getInstance()->get('_observers') as $observer)
		{
			if ($observer instanceof PlgSystemCache)
			{
				$observer->get('_cache')->setCaching(false);
				break;
			}
		
		}
	
	}
	
	
	public static function renders($name, $elements)
	{
		$result = '';
		foreach ($elements as $index => $element)
		{
			$result .= self::render($name, $element);
		}
		
		return $result;
	}
	
	
	public static function render($name, $current = null)
	{
		if (!is_null($current))
		{
			$old = self::$current;
			self::$current = $current;
		}
		
		$result = JLayoutHelper::render("foxcontact.{$name}", self::$form, null, array('component' => 'com_foxcontact'));
		if (isset($old))
		{
			self::$current = $old;
		}
		
		return $result;
	}
	
	
	public static function nvl($v1, $v2)
	{
		return !empty($v1) ? $v1 : $v2;
	}

}