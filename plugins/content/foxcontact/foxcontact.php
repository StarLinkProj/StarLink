<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.lang');

class PlgContentFoxContact extends JPlugin
{
	
	public function onContentAfterSave($context, $table)
	{
		if ($context === 'com_menus.item' && isset($table->id) && isset($table->link))
		{
			$base_link = 'index.php?option=com_foxcontact&view=foxcontact';
			$link = substr($table->link, 0, strlen($base_link));
			if ($link === $base_link)
			{
				$table->link = "{$link}&Itemid={$table->id}";
				$table->store();
			}
		
		}
	
	}
	
	
	public function onContentPrepareForm($form, $data)
	{
		$editing_module = is_object($data) && isset($data->module) && $data->module == 'mod_foxcontact';
		$editing_menu = is_array($data) && isset($data['request']['option']) && $data['request']['option'] == 'com_foxcontact';
		FoxJoomlaLang::load($editing_module || $editing_menu, $editing_module);
		return true;
	}

}