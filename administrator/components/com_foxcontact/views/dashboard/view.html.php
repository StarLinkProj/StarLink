<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
require_once __DIR__ . '/../foxview.html.php';

class FoxContactViewDashboard extends FoxView
{
	protected $extension_id;
	protected $xml;
	
	public function display($tpl = null)
	{
		$this->extension_id = $this->get('ExtensionId');
		$this->xml = new SimpleXMLElement(JPATH_ADMINISTRATOR . '/components/com_foxcontact/foxcontact.xml', 0, true);
		JFactory::getLanguage()->load('com_foxcontact.sys', JPATH_COMPONENT);
		$this->addToolBar();
		$this->addSubmenu('dashboard');
		JHtml::_('jquery.framework');
		parent::display($tpl);
	}
	
	
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_FOXCONTACT_SUBMENU_DASHBOARD'), 'mail');
		if (JFactory::getUser()->authorise('core.admin', 'com_foxcontact'))
		{
			JToolBarHelper::preferences('com_foxcontact');
		}
	
	}

}