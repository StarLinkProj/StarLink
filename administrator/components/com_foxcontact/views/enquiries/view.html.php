<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
require_once __DIR__ . '/../foxview.html.php';
jimport('foxcontact.html.resource');

class FoxContactViewEnquiries extends FoxView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->addToolbar();
		$this->addSubmenu('enquiries');
		JHtml::_('jquery.framework');
		$document = JFactory::getDocument();
		$document->addScript(FoxHtmlResource::path('/administrator/components/com_foxcontact/js/enquiries', 'js'));
		parent::display($tpl);
	}
	
	
	protected function addToolbar()
	{
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_FOXCONTACT_SUBMENU_ENQUIRIES'), 'list-2');
		$bar->appendButton('Link', 'cog', 'JTOOLBAR_EXPORT', 'index.php?option=com_foxcontact&task=enquiries.export');
		JToolbarHelper::deleteList(JText::_('COM_FOXCONTACT_ARE_YOU_SURE'), 'enquiries.delete', 'JACTION_DELETE');
		if (JFactory::getUser()->authorise('core.admin', 'com_foxcontact'))
		{
			JToolBarHelper::preferences('com_foxcontact');
		}
	
	}

}