<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 * Contributions by Arthur Plouet
 */
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class com_foxcontactInstallerScript
{
	private $results = array();
	private $component_name;
	private $extension_name;
	private $event;
	
	public function __construct($parent)
	{
	}
	
	
	public function install($parent)
	{
		JLog::addLogger(array('text_file' => 'foxcontact.install.txt', 'text_entry_format' => "{DATE}\t{TIME}\t{PRIORITY}\t{CATEGORY}\t{MESSAGE}"), JLog::ALL, array('install'));
		try
		{
			JLog::add("Running {$this->event} on: " . PHP_OS . " | {$_SERVER['SERVER_SOFTWARE']} | php " . PHP_VERSION . ' | safe_mode: ' . intval(ini_get('safe_mode')) . ' | interface: ' . php_sapi_name(), JLog::INFO, 'install');
		}
		catch (RuntimeException $e)
		{
		}
		
		$this->chain_install($parent);
		$this->clear_overrides();
		$this->clear_cache();
		$this->clear_obsolete();
		$this->logo($parent);
	}
	
	
	public function uninstall()
	{
		$this->clear_overrides();
		$this->clear_cache();
	}
	
	
	public function update($parent)
	{
		$this->clear_obsolete();
		$this->install($parent);
	}
	
	
	public function preflight($type, $parent)
	{
		$this->component_name = $parent->get('element');
		$this->extension_name = substr($this->component_name, 4);
		$this->event = $type;
		$this->check_previous_version($parent);
		$this->check_joomla_version($parent);
	}
	
	
	private function check_previous_version($parent)
	{
		if ($this->event === 'update')
		{
			$installed_version = $this->getInstalledVersion();
			$required_version = (string) $parent->get('manifest')->{'requiredVersion'};
			if ($installed_version !== '' && version_compare($installed_version, $required_version, '<'))
			{
				$current_version = (string) $parent->get('manifest')->{'version'};
				$msg = '<h3><i class="icon-lock"></i> ' . JText::sprintf('COM_FOXCONTACT_INCOMPATIBLE_UPGRADE', $current_version, $installed_version) . '</h3>' . '<p>' . JText::sprintf('COM_FOXCONTACT_UNINSTALL', $installed_version, $current_version) . '</p>' . '<p>' . JText::_('COM_FOXCONTACT_ANNOTATE_CONFIGURATION') . '</p>';
				JFactory::getApplication()->enqueueMessage($msg, 'error');
				JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_installer', false));
			}
		
		}
	
	}
	
	
	private function getInstalledVersion()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('manifest_cache'))->from($db->quoteName('#__extensions'))->where("{$db->quoteName('type')} = {$db->quote('component')}")->where("{$db->quoteName('element')} = {$db->quote('com_foxcontact')}");
		$manifest = (string) $db->setQuery($query)->loadResult();
		$manifest = json_decode($manifest, true) or $manifest = array();
		return (string) (isset($manifest['version']) ? $manifest['version'] : '');
	}
	
	
	private function check_joomla_version($parent)
	{
		$j_version = new JVersion();
		$j_min = (string) $parent->get('manifest')->attributes()->{'version'};
		$j_max = (string) $parent->get('manifest')->{'version'};
		if (version_compare($j_version->RELEASE, $j_min, '<') || version_compare($j_version->RELEASE, $j_max, '>'))
		{
			$j_max = preg_replace('/\\.[0-9]+$/', '', $j_max);
			JFactory::getApplication()->enqueueMessage('<h3><i class="icon-warning"></i> Fox Contact ' . $j_max . ' has not been tested on Joomla ' . $j_version->RELEASE . '</h3>' . 'The installation process will continue, but the current version may be incompatible with your current Joomla version.<br/>' . '<b>You should upgrade to Fox Contact ' . $j_version->RELEASE . ' series as soon as possible.</b><br/>' . 'If you have an active subscription, download the latest release through the <a href="http://www.fox.ra.it/account-recovery.html">account recovery form</a> now.<br/>' . 'Please do it before <a href="http://www.fox.ra.it/forum/">asking for technical support</a>.', 'warning');
		}
	
	}
	
	
	private function getDownloadIdUrlParam($dir)
	{
		$file_name = realpath("{$dir}/models/download_id.php");
		$download_id = urlencode($file_name !== false ? require $file_name : '');
		if (!empty($download_id))
		{
			return "dlid={$download_id}";
		}
		
		return '';
	}
	
	
	public function postflight($type, $parent)
	{
		$this->check_environment();
		$extra_query = $this->getDownloadIdUrlParam($parent->getParent()->getPath('source'));
		JEventDispatcher::getInstance()->register('onExtensionAfterInstall', function ($installer, $my_id) use($extra_query)
		{
			if ($my_id !== false)
			{
				$db = JFactory::getDbo();
				$db->setQuery("UPDATE {$db->quoteName('#__update_sites')} " . "SET {$db->quoteName('extra_query')} = {$db->quote($extra_query)} " . "WHERE {$db->quoteName('update_site_id')} IN (" . "  SELECT {$db->quoteName('update_site_id')} " . "  FROM {$db->quoteName('#__update_sites_extensions')} " . "  WHERE {$db->quoteName('extension_id')} = {$db->quote($my_id)}" . ')')->execute();
			}
		
		});
	}
	
	
	private function chain_install($parent)
	{
		$manifest = $parent->get('manifest');
		$extensions = isset($manifest->chain->extension) ? $manifest->chain->extension : array();
		foreach ($extensions as $extension)
		{
			$attributes = $extension->attributes();
			$item = $parent->getParent()->getPath('source') . '/' . $attributes['directory'] . '/' . $attributes['name'];
			if (is_dir($item))
			{
				$installer = new JInstaller();
				$installed = $installer->install($item);
				$this->results[(string) $attributes['name']] = array('type' => strtoupper((string) $attributes['type']), 'result' => $installed ? 'SUCCESS' : 'ERROR', 'icon' => $installed ? 'ok' : 'delete');
			}
		
		}
		
		$this->results[$this->component_name] = array('type' => 'COMPONENT', 'result' => 'SUCCESS', 'icon' => 'ok');
	}
	
	
	private function check_environment()
	{
		foreach (array('captcha', 'config') as $checker_name)
		{
			include_once JPATH_ROOT . "/libraries/foxcontact/environment/{$checker_name}.php";
			$class = "FoxEnvironment{$checker_name}";
			if (class_exists($class))
			{
				$checker = new $class();
				$checker->{'run'}();
			}
		
		}
	
	}
	
	
	private function logo($parent)
	{
		$manifest = $parent->get('manifest');
		$title = explode(' ', JText::_((string) $manifest->name));
		$last_word =& $title[count($title) - 1];
		$last_word = '<span class="orange">' . $last_word . '</span>';
		$title = implode(' ', $title);
		echo '<style type="text/css">' . '@import url("' . JUri::base(true) . '/components/' . $this->component_name . '/css/install.css' . '");' . '</style>' . '<img ' . 'class="product-logo" width="128" height="128" ' . 'src="' . (string) $manifest->authorUrl . 'logo/' . $this->extension_name . '-' . $this->event . '-logo.jpg" ' . 'alt="' . JText::_((string) $manifest->name) . ' Logo" ' . '/>' . '<div class="info-box">' . '<h2>' . $title . '</h2>' . '<h5>' . JText::_('COM_FOXCONTACT_SLOGAN') . '</h5>';
		foreach ($this->results as $extension)
		{
			$outcome = JText::sprintf('COM_INSTALLER_INSTALL_' . $extension['result'], JText::_('COM_INSTALLER_TYPE_' . $extension['type']));
			echo '<div>' . '<span class="icon-' . $extension['icon'] . '"></span>' . $outcome . '</div>';
		}
		
		$direction = JFactory::getLanguage()->isRtl() ? 'left' : 'right';
		echo '<a class="btn btn-primary" href="index.php?option=com_foxcontact">' . JText::_('COM_FOXCONTACT_GET_STARTED') . ' <span class="icon-' . $direction . 'arrow"></span>' . '</a>';
		echo '</div>';
	}
	
	
	private function clear_overrides()
	{
		$templates = glob(JPATH_ROOT . '/templates/*', GLOB_ONLYDIR | GLOB_NOSORT) or $templates = array();
		foreach ($templates as $template)
		{
			$overrides = glob("{$template}/html/*_foxcontact", GLOB_ONLYDIR | GLOB_NOSORT) or $overrides = array();
			foreach ($overrides as $override)
			{
				rename($override, $override . '.' . uniqid());
			}
		
		}
	
	}
	
	
	private function clear_cache()
	{
		foreach (array(JPATH_ROOT, JPATH_ADMINISTRATOR) as $path)
		{
			$files = glob($path . '/cache/foxcontact/*', GLOB_NOSORT) or $files = array();
			foreach ($files as $file)
			{
				unlink($file);
			}
		
		}
	
	}
	
	
	private function clear_obsolete()
	{
		@unlink(JPATH_ROOT . '/libraries/foxcontact/html/security.php');
		@unlink(JPATH_ROOT . '/libraries/foxcontact/html/mimetype.php');
		foreach (array(JPATH_ROOT, JPATH_ADMINISTRATOR) as $path)
		{
			$folders = glob($path . '/language/*-*', GLOB_ONLYDIR | GLOB_NOSORT) or $files = array();
			foreach ($folders as $folder)
			{
				$files = glob($folder . '/*foxcontact*', GLOB_NOSORT) or $files = array();
				foreach ($files as $file)
				{
					unlink($file);
				}
			
			}
		
		}
	
	}

}