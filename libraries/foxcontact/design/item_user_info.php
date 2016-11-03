<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.useragentparser');

class FoxDesignItemUserInfo extends FoxDesignItem
{
	private static $ip_text_cache = array();
	
	protected function finalize()
	{
		parent::finalize();
		$this->set('label', JText::_('COM_FOXCONTACT_CLIENT_INFO'));
	}
	
	
	public function update($post_data)
	{
		$user_info_data = array();
		if ($this->get('info.device', false) || $this->get('info.os', false) || $this->get('info.browser', false))
		{
			$uaparser = new FoxHtmlUserAgentParser($_SERVER['HTTP_USER_AGENT']);
			if ($this->get('info.device', false))
			{
				$user_info_data['device'] = self::normalize($uaparser->getDevice());
			}
			
			if ($this->get('info.os', false))
			{
				$user_info_data['os'] = self::normalize($uaparser->getOS());
			}
			
			if ($this->get('info.browser', false))
			{
				$user_info_data['browser'] = self::normalize($uaparser->getBrowser());
			}
		
		}
		
		if ($this->get('info.ip', false))
		{
			$user_info_data['ip'] = self::getCurrentIp();
		}
		
		$this->setValue($user_info_data);
	}
	
	
	public static function getCurrentIp()
	{
		return (string) JFactory::getApplication()->input->server->get('REMOTE_ADDR', '', 'string');
	}
	
	
	private static function normalize($data)
	{
		$normalized = array();
		foreach ($data as $k => $v)
		{
			$normalized[strtolower($k)] = $v !== '-' ? $v : '';
		}
		
		return $normalized;
	}
	
	
	public function getValueForUser()
	{
		return $this->getValueAsText();
	}
	
	
	public function getValueForAdmin()
	{
		return $this->getValueAsText();
	}
	
	
	public function getValueAsText()
	{
		return implode(', ', array_filter(array($this->getDeviceText(), $this->getOsText(), $this->getBrowserText(), $this->getIpText())));
	}
	
	
	public function getDeviceText()
	{
		$values = $this->getValue();
		return isset($values['device']) ? $values['device']['model'] : '';
	}
	
	
	public function getOsText()
	{
		$values = $this->getValue();
		return isset($values['os']) ? $values['os']['name'] : '';
	}
	
	
	public function getBrowserText()
	{
		$values = $this->getValue();
		return isset($values['browser']) ? "{$values['browser']['name']} {$values['browser']['major']}" : '';
	}
	
	
	public function getIpText()
	{
		$values = $this->getValue();
		return self::getIpAsText(isset($values['ip']) ? $values['ip'] : '');
	}
	
	
	public static function getIpAsText($ip)
	{
		$ip_key = !empty($ip) ? $ip : '-';
		if (!isset(self::$ip_text_cache[$ip_key]))
		{
			self::$ip_text_cache[$ip_key] = self::renderIp($ip);
		}
		
		return self::$ip_text_cache[$ip_key];
	}
	
	
	private static function renderIp($ip)
	{
		if (function_exists('geoip_record_by_name'))
		{
			$record = @geoip_record_by_name($ip) or $record = array('country_name' => JText::_('COM_FOXCONTACT_UNKNOWN_COUNTRY'), 'city' => JText::_('COM_FOXCONTACT_UNKNOWN_LOCATION'));
			$description = JText::sprintf('COM_FOXCONTACT_LOCATION_ORIGIN', utf8_encode("{$record['country_name']}, {$record['city']}"));
			$ip .= " - {$description}";
		}
		
		return $ip;
	}

}