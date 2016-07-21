<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.action.base');
jimport('foxcontact.joomla.log');

class FoxActionNewsletterJNews extends FoxActionBase
{
	
	public function process($target)
	{
		$item = $this->form->getDesign()->getFoxDesignItemByType('newsletter');
		if (is_null($item) || $item->getNewsletterType() !== 'jnews')
		{
			return true;
		}
		
		$lists = $item->getSelectedIds();
		if (empty($lists))
		{
			return true;
		}
		
		if (!class_exists('jNews_Config'))
		{
			return false;
		}
		
		$config = new jNews_Config();
		$subscriber = new stdClass();
		$subscriber->list_id = $lists;
		$subscriber->name = $this->form->getName();
		$subscriber->email = JMailHelper::cleanAddress($this->form->getEmail());
		if (empty($subscriber->email))
		{
			return true;
		}
		
		$subscriber->confirmed = !(bool) $config->get('require_confirmation');
		$subscriber->receive_html = 1;
		$subscriber->ip = jNews_Subscribers::getIP();
		$subscriber->subscribe_date = jnews::getNow();
		$subscriber->language_iso = 'eng';
		$subscriber->timezone = '00:00:00';
		$subscriber->blacklist = 0;
		$subscriber->user_id = JFactory::getUser()->id;
		$sub_id = 0;
		jNews_Subscribers::saveSubscriber($subscriber, $sub_id, true);
		if (empty($sub_id))
		{
			FoxLog::add("Unable to save the user to the newsletter ({$item->getNewsletterType()}): User (Name: '{$this->form->getName()}' Email: '{$this->form->getEmail()}')", JLog::INFO, 'action');
			return true;
		}
		
		$subscriber->id = $sub_id;
		jNews_ListsSubs::saveToListSubscribers($subscriber);
		FoxLog::add("Newsletter ({$item->getNewsletterType()}): User (Name: '{$this->form->getName()}' Email: '{$this->form->getEmail()}') subscribed to the lists (" . implode(',', $lists) . ').', JLog::INFO, 'action');
		return true;
	}

}