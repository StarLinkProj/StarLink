<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.action.base');

class FoxActionNewsletterPlugin extends FoxActionBase
{
	
	public function process($target)
	{
		$contact = new stdClass();
		$data = array('contact_name' => $this->form->getName(), 'contact_email' => JMailHelper::cleanAddress($this->form->getEmail()), 'contact_subject' => '?', 'contact_message' => '?');
		JPluginHelper::importPlugin('contact');
		JEventDispatcher::getInstance()->trigger('onSubmitContact', array(&$contact, &$data));
		return true;
	}

}