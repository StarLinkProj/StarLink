<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.log');

class FoxEnvironmentConfig
{
	
	public function __construct()
	{
		JLog::addLogger(array('text_file' => 'foxcontact.php', 'text_entry_format' => "{DATE}\t{TIME}\t{PRIORITY}\t{CATEGORY}\t{MESSAGE}"), JLog::ALL, array('install'));
	}
	
	
	public function run()
	{
		$params = JComponentHelper::getParams('com_foxcontact')->toObject();
		$this->testAddresses($params);
		$this->testDNS($params);
		$table = JTable::getInstance('extension');
		$table->load(array('element' => 'com_foxcontact', 'client_id' => 1));
		$table->bind(array('params' => json_encode($params)));
		$table->check() && $table->store();
	}
	
	
	private function testDNS(&$params)
	{
		FoxLog::add('--- Determining if this system is able to query DNS records ---', JLog::INFO, 'install');
		if (!function_exists('checkdnsrr'))
		{
			FoxLog::add('checkdnsrr function doesn\'t exist.', JLog::INFO, 'install');
			$params->use_dns = '0';
		}
		else
		{
			FoxLog::add('checkdnsrr function found. Let\'s see if it works.', JLog::INFO, 'install');
			$record_found = checkdnsrr('fox.ra.it', 'MX');
			FoxLog::add('testing function [checkdnsrr]... [' . intval($record_found) . ']', JLog::INFO, 'install');
			$params->use_dns = $record_found ? 'dns_check' : '0';
		}
		
		FoxLog::add("--- Method choosen to query DNS records is [{$params->use_dns}] ---", JLog::INFO, 'install');
	}
	
	
	private function testAddresses(&$params)
	{
		$config = JFactory::getConfig();
		if ($config->get('mailer') == 'smtp' && (bool) $config->get('smtpauth') && strpos($config->get('smtpuser'), '@') !== false)
		{
			isset($params->adminemailfrom) or $params->adminemailfrom = new stdClass();
			$params->adminemailfrom->select = 'custom';
			$params->adminemailfrom->name = $config->get('fromname');
			$params->adminemailfrom->email = $config->get('smtpuser');
			isset($params->submitteremailfrom) or $params->submitteremailfrom = new stdClass();
			$params->submitteremailfrom->select = 'custom';
			$params->submitteremailfrom->name = $config->get('fromname');
			$params->submitteremailfrom->email = $config->get('smtpuser');
		}
	
	}

}