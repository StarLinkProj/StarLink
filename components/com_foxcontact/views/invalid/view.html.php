<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.link');
jimport('foxcontact.joomla.lang');

class FoxContactViewInvalid extends JViewLegacy
{
	protected $valid_items;
	
	public function display($tpl = null)
	{
		FoxJoomlaLang::load(false, true);
		$application = JFactory::getApplication();
		$menu = $application->getMenu();
		$this->valid_items = $menu->getItems('component', 'com_foxcontact');
		return parent::display($tpl);
	}

}