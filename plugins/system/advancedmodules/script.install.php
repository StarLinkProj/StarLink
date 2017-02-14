<?php
/**
 * @package         Advanced Module Manager
 * @version         7.1.0
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/script.install.helper.php';

class PlgSystemAdvancedModulesInstallerScript extends PlgSystemAdvancedModulesInstallerScriptHelper
{
	public $name           = 'ADVANCED_MODULE_MANAGER';
	public $alias          = 'advancedmodulemanager';
	public $extname        = 'advancedmodules';
	public $extension_type = 'plugin';

	public function uninstall($adapter)
	{
		$this->uninstallComponent($this->extname);
	}

	public function onAfterInstall($route)
	{
		$this->setPluginOrdering();

		if ($this->install_type == 'update')
		{
			$this->deleteOldFiles();
		}
	}

	private function setPluginOrdering()
	{
		$query = $this->db->getQuery(true)
			->update('#__extensions')
			->set($this->db->quoteName('ordering') . ' = -1')
			->where($this->db->quoteName('type') . ' = ' . $this->db->quote('plugin'))
			->where($this->db->quoteName('element') . ' = ' . $this->db->quote('advancedmodules'))
			->where($this->db->quoteName('folder') . ' = ' . $this->db->quote('system'));
		$this->db->setQuery($query);
		$this->db->execute();

		JFactory::getCache()->clean('_system');
	}

	private function deleteOldFiles()
	{
		JFile::delete(
			[
				JPATH_PLUGINS . '/system/advancedmodules/advancedmodulehelper_legacy.php',
				JPATH_PLUGINS . '/system/advancedmodules/advancedmodulehelper.php',
				JPATH_PLUGINS . '/system/advancedmodules/helper.php',
				JPATH_PLUGINS . '/system/advancedmodules/modulehelper_legacy.php',
			]
		);
	}
}
