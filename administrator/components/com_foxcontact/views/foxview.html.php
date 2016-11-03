<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxView extends JViewLegacy
{
	protected $sidebar;
	
	public function display($tpl = null)
	{
		JFactory::getDocument()->addStyleSheet(JUri::base(true) . '/components/com_foxcontact/css/component.css');
		$this->sidebar = JHtmlSidebar::render();
		return parent::display($tpl);
	}
	
	
	public function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(JText::_('COM_FOXCONTACT_SUBMENU_DASHBOARD'), 'index.php?option=com_foxcontact&view=dashboard', $vName == 'dashboard');
		JHtmlSidebar::addEntry(JText::_('COM_FOXCONTACT_SUBMENU_ENQUIRIES'), 'index.php?option=com_foxcontact&view=enquiries', $vName == 'enquiries');
	}

}