<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.action.email');

class FoxActionEmailAdmin extends FoxActionEmail
{
	protected $type = 'Administrators notification email';
	private $cache = array();
	
	protected function isEnable()
	{
		$all_recipients = array_merge($this->getRecipients('to', 'to_address'), $this->getRecipients('cc', 'cc_address'), $this->getRecipients('bcc', 'bcc_address'));
		return count($all_recipients) > 0;
	}
	
	
	protected function prepare($mail)
	{
		$render = $this->form->getMessageRender(false);
		$this->setFrom($mail, '', $this->form->getName(), $this->form->getEmail(), $this->form->getName());
		$this->setTo($mail, 'to', 'to_address', 'addRecipient');
		$this->setTo($mail, 'cc', 'cc_address', 'addCC');
		$this->setTo($mail, 'bcc', 'bcc_address', 'addBCC');
		$mail->setSubject($render->renderSubject('email_subject'));
		$mail->Encoding = 'quoted-printable';
		$mail->setBody($render->renderBody('email_body'));
		$this->prepareAlternateBody($mail);
		$this->addAttachments($mail);
	}
	
	
	private function setTo($mail, $key, $param_name, $method)
	{
		$recipients = $this->getRecipients($key, $param_name);
		foreach ($recipients as $recipient)
		{
			$mail->{$method}(JMailHelper::cleanAddress($recipient));
		}
	
	}
	
	
	private function getRecipients($key, $param_name)
	{
		if (!isset($this->cache["{$key}:{$param_name}"]))
		{
			$this->cache["{$key}:{$param_name}"] = $this->findRecipients($key, $param_name);
		}
		
		return $this->cache["{$key}:{$param_name}"];
	}
	
	
	private function findRecipients($key, $param_name)
	{
		$recipients = array();
		$list = $this->params->get($param_name, null);
		$list = !empty($list) ? explode(',', $list) : array();
		foreach ($list as $recipient)
		{
			$this->addRecipientToList($recipients, $recipient);
		}
		
		foreach ($this->form->getDesign()->getItems() as $item)
		{
			foreach ($item->getRecipients($key) as $recipient)
			{
				$this->addRecipientToList($recipients, $recipient);
			}
		
		}
		
		return $recipients;
	}
	
	
	private function addRecipientToList(&$recipients, $recipient)
	{
		$recipient = trim($recipient);
		if (!empty($recipient) && !in_array($recipient, $recipients))
		{
			$recipients[] = $recipient;
		}
	
	}

}