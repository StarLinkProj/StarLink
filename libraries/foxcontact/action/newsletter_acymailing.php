<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.action.base');
jimport('foxcontact.joomla.log');

class FoxActionNewsletterAcyMailing extends FoxActionBase
{
	
	public function process($target)
	{
		$item = $this->form->getDesign()->getFoxDesignItemByType('newsletter');
		if (is_null($item) || $item->getNewsletterType() !== 'acymailing')
		{
			return true;
		}
		
		$lists = $item->getSelectedIds();
		if (empty($lists))
		{
			return true;
		}
		
		$subscriber = new stdClass();
		$subscriber->name = $this->form->getName();
		$subscriber->email = JMailHelper::cleanAddress($this->form->getEmail());
		$user = acymailing_get('class.subscriber');
		$user->checkVisitor = false;
		$sub_id = $user->save($subscriber);
		if (empty($sub_id))
		{
			FoxLog::add("Unable to save the user to the newsletter ({$item->getNewsletterType()}): User (Name: '{$this->form->getName()}' Email: '{$this->form->getEmail()}')", JLog::INFO, 'action');
			return true;
		}
		
		$new_subscription = array();
		foreach ($lists as $list_id)
		{
			$new_subscription[$list_id] = array('status' => 1);
		}
		
		if (!empty($new_subscription))
		{
			$user->saveSubscription($sub_id, $new_subscription);
		}
		
		FoxLog::add("Newsletter ({$item->getNewsletterType()}): User (Name: '{$this->form->getName()}' Email: '{$this->form->getEmail()}') subscribed to the lists (" . implode(',', $lists) . ').', JLog::INFO, 'action');
		return true;
	}

}