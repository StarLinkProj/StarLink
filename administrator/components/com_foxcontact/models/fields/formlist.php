<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
JFormHelper::loadFieldClass('groupedlist');

class JFormFieldFormList extends JFormFieldGroupedList
{
	public $type = 'FormList';
	
	protected function getGroups()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id as value, title as text');
		$query->from('#__menu');
		$query->where('link LIKE ' . $db->quote('%option=com_foxcontact&view=foxcontact%'));
		$db->setQuery($query);
		$components = $db->loadObjectList();
		$query->clear();
		$query->select('-id as value, title as text');
		$query->from('#__modules');
		$query->where('module = ' . $db->quote('mod_foxcontact'));
		$db->setQuery($query);
		$modules = $db->loadObjectList();
		return array(JText::_('COM_FOXCONTACT_MENU_ITEMS') => $components, JText::_('COM_FOXCONTACT_MODULES') => $modules);
	}

}