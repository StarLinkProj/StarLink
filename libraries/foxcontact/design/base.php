<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.design.item');

class FoxDesignBase
{
	
	protected function __construct($value, $owner = null, $deep = 0, $root = null)
	{
		$this->init();
		$this->load(is_string($value) ? json_decode($value, true) : $value, $owner, $deep, $root ? $root : $this);
		$this->finalize();
	}
	
	
	protected function init()
	{
	}
	
	
	protected function finalize()
	{
	}
	
	
	private function load($data, $owner, $deep, $root)
	{
		if ($data !== false)
		{
			foreach ($data as $key => $value)
			{
				$this->{$key} = is_array($value) ? $this->getStruct($value, $key, $deep + 1, $root, $owner) : $value;
			}
		
		}
	
	}
	
	
	private function getStruct($value, $owner, $deep, $root, $parent)
	{
		if ($parent === 'items')
		{
			$type = $value['type'];
			$class_name = 'FoxDesignItem' . str_replace('_', '', $type);
			jimport("foxcontact.design.item_{$type}");
			$item = class_exists($class_name) ? new $class_name($value, $owner, $deep + 1, $root) : new FoxDesignItem($value, $owner, $deep + 1, $root);
			$root->addItem($item);
			return $item;
		}
		
		return new FoxDesignBase($value, $owner, $deep + 1, $root);
	}
	
	
	public function get($name, $default = null)
	{
		$current = $this;
		foreach (explode('.', $name) as $key)
		{
			if (!isset($current->{$key}))
			{
				return $default;
			}
			
			$current = $current->{$key};
		}
		
		return $current;
	}
	
	
	public function isEmpty($name)
	{
		$value = $this->get($name);
		return empty($value);
	}
	
	
	public function set($name, $value)
	{
		$this->{$name} = $value;
	}
	
	
	public function getStyleWidth()
	{
		$width = $this->get('width', null);
		switch (!is_null($width) ? $width->get('unit') : '')
		{
			case 'px':
				return "width: {$width->get('value')}{$width->get('unit')};";
			default:
				return '';
		}
	
	}
	
	
	public function getStyleHeight()
	{
		$height = $this->get('height', null);
		switch (!is_null($height) ? $height->get('unit') : '')
		{
			case 'px':
				return "height: {$height->get('value')}{$height->get('unit')};";
			case 'auto':
				$width = $this->get('width', null);
				if (is_null($width) || $width->get('unit') !== 'px')
				{
					$width = FoxFormModel::getFormByUid($this->get('uid'))->getDesign()->get('option.control.width');
				}
				
				$height_val = $width->get('value') * 0.75;
				return "height: {$height_val}px;";
			default:
				return '';
		}
	
	}

}