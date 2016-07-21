<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.form.model');
jimport('foxcontact.form.render');

class FoxContactViewFoxContact extends JViewLegacy
{
	protected $form;
	
	public function display($tpl = null)
	{
		$menu = JFactory::getApplication()->getMenu()->getActive();
		if (is_null($menu))
		{
			JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_foxcontact&view=invalid'));
		}
		
		$this->form = FoxFormModel::getFormByUid("c{$menu->id}");
		if ($description = $menu->params->get('menu-meta_description'))
		{
			$this->document->setDescription($description);
		}
		
		if ($keywords = $menu->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $keywords);
		}
		
		if ($robots = $menu->params->get('robots'))
		{
			$this->document->setMetadata('robots', $robots);
		}
		
		return parent::display($tpl);
	}

}