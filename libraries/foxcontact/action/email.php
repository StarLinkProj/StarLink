<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.action.base');
jimport('foxcontact.html.encoder');
jimport('foxcontact.design.item_attachments');
jimport('foxcontact.joomla.log');

abstract class FoxActionEmail extends FoxActionBase
{
	protected $type = 'Abstract notification email';
	
	public function process($target)
	{
		if ($this->isEnable())
		{
			$mail = JFactory::getMailer();
			$this->prepare($mail);
			return $this->send($mail);
		}
		
		return true;
	}
	
	
	protected function isEnable()
	{
		return true;
	}
	
	
	protected abstract function prepare($mail);
	
	protected function setFrom($mail, $from_email = '', $from_name = '', $reply_to_email = '', $reply_to_name = '')
	{
		$this->setFromSafe($mail, trim($from_email), trim($from_name), trim($reply_to_email), trim($reply_to_name));
	}
	
	
	private function setFromSafe($mail, $from_email, $from_name, $reply_to_email, $reply_to_name)
	{
		$config = JFactory::getConfig();
		$mail->setSender(array(JMailHelper::cleanAddress(!empty($from_email) ? $from_email : $config->get('mailfrom', '')), !empty($from_name) ? $from_name : $config->get('fromname', '')));
		$mail->clearReplyTos();
		if (!empty($reply_to_email))
		{
			$mail->addReplyTo(JMailHelper::cleanAddress($reply_to_email), $reply_to_name);
		}
	
	}
	
	
	protected function prepareAlternateBody($mail)
	{
		$html2text = JPATH_ROOT . '/libraries/vendor/phpmailer/phpmailer/extras/class.html2text.php';
		if (file_exists($html2text))
		{
			require_once $html2text;
			$html2text = new Html2Text($mail->Body);
			$mail->AltBody = $html2text->get_text();
		}
		else
		{
			$mail->isHtml(true);
		}
	
	}
	
	
	protected function addAttachments($mail)
	{
		$item = $this->form->getDesign()->getFoxDesignItemByType('attachments') or $item = new FoxDesignItemAttachments(array());
		$root = JPATH_SITE . '/components/com_foxcontact/uploads/';
		$sum = 0;
		foreach ($item->getValue() as $file)
		{
			$sum += filesize("{$root}{$file['filename']}");
		}
		
		if ($sum < constant($this->params->get('email_size_limit', 'MB2')))
		{
			foreach ($item->getValue() as $file)
			{
				$mail->addAttachment("{$root}{$file['filename']}", $file['realname']);
			}
		
		}
	
	}
	
	
	private function send($mail)
	{
		$result = $mail->Send();
		if ($result !== true)
		{
			if (is_object($result))
			{
				$info = $result->getMessage();
			}
			else
			{
				if (!empty($mail->ErrorInfo))
				{
					$info = $mail->ErrorInfo;
				}
				else
				{
					$info = JText::_('JLIB_MAIL_FUNCTION_OFFLINE');
				}
			
			}
			
			FoxLog::add("{$this->getClassName()} Unable to send email. ({$info})", JLog::ERROR, 'action');
			$info = FoxHtmlEncoder::encode($info);
			$this->form->getBoard()->add(JText::_('COM_FOXCONTACT_ERR_SENDING_MAIL') . ". {$info}", FoxFormBoard::error);
			return false;
		}
		
		FoxLog::add("{$this->type} sent.", JLog::INFO, 'action');
		return true;
	}
	
	
	private function getClassName()
	{
		return get_class($this);
	}

}