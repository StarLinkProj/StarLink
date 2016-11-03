<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.log');

class FoxEnvironmentCaptcha
{
	private static $tests = array('use_gd' => 'isGDUsable');
	
	public function __construct()
	{
		JLog::addLogger(array('text_file' => 'foxcontact.php', 'text_entry_format' => "{DATE}\t{TIME}\t{PRIORITY}\t{CATEGORY}\t{MESSAGE}"), JLog::ALL, array('install'));
	}
	
	
	public function run()
	{
		FoxLog::add('--- Determining if this system is able to draw captcha images ---', JLog::INFO, 'install');
		$method = 'disabled';
		foreach (self::$tests as $m => $test)
		{
			if ($this->{$test}())
			{
				FoxLog::add("Test for: {$m} ok.", JLog::INFO, 'install');
				$method = $m;
				break;
			}
			else
			{
				FoxLog::add("Test for: {$m} failed.", JLog::INFO, 'install');
			}
		
		}
		
		$db = JFactory::getDbo();
		$table = $db->quoteName('#__foxcontact_settings');
		$name_col = $db->quoteName('name');
		$value_col = $db->quoteName('value');
		$name_val = $db->quote('captchadrawer');
		$value_val = $db->quote($method);
		$db->setQuery("REPLACE INTO {$table} ({$name_col}, {$value_col}) VALUES ({$name_val}, {$value_val});")->execute();
		FoxLog::add("--- Method choosen to draw captcha images is [{$method}] ---", JLog::INFO, 'install');
	}
	
	
	public function isGDUsable()
	{
		if (!extension_loaded('gd') || !function_exists('gd_info'))
		{
			FoxLog::add('gd extension not found.', JLog::INFO, 'install');
			return false;
		}
		
		FoxLog::add('gd extension found. Let\'s see if it works.', JLog::INFO, 'install');
		$gd_info = gd_info();
		foreach ($gd_info as $key => $line)
		{
			FoxLog::add("{$key}... [{$line}]", JLog::INFO, 'install');
		}
		
		$result = true;
		$result &= $this->testfunction('imagecreate');
		$result &= $this->testfunction('imagecolorallocate');
		$result &= $this->testfunction('imagefill');
		$result &= $this->testfunction('imageline');
		$result &= $this->testfunction('imagettftext');
		$result &= $this->testfunction('imagejpeg');
		$result &= $this->testfunction('imagedestroy');
		return $result;
	}
	
	
	private function testfunction($function)
	{
		$result = function_exists($function);
		FoxLog::add("Testing function [{$function}]... [" . intval($result) . ']', JLog::INFO, 'install');
		return $result;
	}

}