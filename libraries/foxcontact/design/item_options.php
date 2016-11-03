<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

abstract class FoxDesignItemOptions extends FoxDesignItem
{
	
	public function update($post_data)
	{
		$candidate = isset($post_data[$this->get('unique_id')]) ? $post_data[$this->get('unique_id')] : '';
		$this->setValue(!is_null($this->getOptionByValue($candidate)) ? $candidate : null);
	}
	
	
	protected function getOptionByValue($value)
	{
		foreach ($this->get('options') as $option)
		{
			if ($option->get('text') === $value)
			{
				return $option;
			}
		
		}
		
		return null;
	}
	
	
	public function getRecipients($key)
	{
		$option = $this->getOptionByValue($this->getValue());
		return !is_null($option) ? explode(',', $option->get($key, '')) : array();
	}

}