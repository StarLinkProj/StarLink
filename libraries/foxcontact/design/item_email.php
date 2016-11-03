<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxDesignItemEmail extends FoxDesignItem
{
	
	protected function getDefaultValue()
	{
		$user = JFactory::getUser();
		return !$user->guest && $this->get('autofill', true) ? $user->email : null;
	}
	
	
	protected function check($value, &$messages)
	{
		parent::check($value, $messages);
		if (!$this->isValueEmpty($value))
		{
			if (!self::isValidEmailByRegex($value) || !self::isValidEmailByDns($value) || JMailHelper::cleanAddress($value) === false)
			{
				$messages[] = $this->getMessage(JText::sprintf('COM_FOXCONTACT_ERR_INVALID_VALUE', $this->get('label')));
			}
		
		}
	
	}
	
	
	private static function isValidEmailByRegex($value)
	{
		return preg_match('/^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,63}$/', strtolower($value)) === 1;
	}
	
	
	private static function isValidEmailByDns($value)
	{
		if (JComponentHelper::getParams('com_foxcontact')->get('use_dns', 'disabled') === 'dns_check')
		{
			$tokens = explode('@', $value);
			$domain = array_pop($tokens);
			return checkdnsrr($domain, 'A');
		}
		
		return true;
	}

}