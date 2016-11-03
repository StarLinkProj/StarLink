<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.action.base');
jimport('foxcontact.html.encoder');
jimport('foxcontact.joomla.log');

class FoxActionJMessenger extends FoxActionBase
{
	
	public function process($target)
	{
		$user_id = $this->params->get('jmessenger_user', null);
		if (!$user_id)
		{
			return true;
		}
		
		$render = $this->form->getMessageRender(false);
		$date = JFactory::getDate()->toSql();
		$subject = FoxHtmlEncoder::encode(trim("{$this->getFromText()} {$render->renderSubject('jmessenger_subject')}"));
		$body = $render->renderBody('jmessenger_body');
		$body = $render->removeClassAttribute($body);
		$result = $this->insert($user_id, $date, $subject, $body);
		if (!$result)
		{
			FoxLog::add('Private message NOT sent to Joomla messenger.', JLog::ERROR, 'action');
			$this->form->getBoard()->add(JText::_('COM_FOXCONTACT_ERR_SENDING_MESSAGE'), FoxFormBoard::error);
		}
		else
		{
			FoxLog::add('Private message sent to Joomla messenger.', JLog::INFO, 'action');
		}
		
		return $result;
	}
	
	
	private function insert($user_id, $date, $subject, $body)
	{
		try
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)->insert($db->quoteName('#__messages'))->set($db->quoteName('user_id_from') . '=' . $db->quote($user_id))->set($db->quoteName('user_id_to') . '=' . $db->quote($user_id))->set($db->quoteName('date_time') . '=' . $db->quote($date))->set($db->quoteName('subject') . '=' . $db->quote($subject))->set($db->quoteName('message') . '=' . $db->quote($body));
			$result = (bool) $db->setQuery($query)->execute();
		}
		catch (Exception $e)
		{
			FoxLog::add("Unable to save the jmessage into the database. Database error details: {$e->getMessage()}", JLog::ERROR, 'action');
			$result = false;
		}
		
		return $result;
	}
	
	
	private function getFromText()
	{
		$name = $this->form->getName();
		$email = $this->form->getEmail();
		if (!empty($email))
		{
			$email = "({$email})";
		}
		
		return trim("{$name} {$email}");
	}

}