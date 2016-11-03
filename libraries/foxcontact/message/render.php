<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 * Contributions by Graeme Moffat
 */
jimport('joomla.mail.helper');
jimport('foxcontact.emogrifier.emogrifier');
jimport('foxcontact.message.template');
jimport('foxcontact.html.elem');
jimport('foxcontact.html.encoder');
jimport('foxcontact.design.item_user_info');

class FoxMessageRender
{
	private $render_is_for_user = true, $form;
	
	public function __construct($form)
	{
		$this->form = $form;
	}
	
	
	public function setRenderIsForUser($render_is_for_user)
	{
		$this->render_is_for_user = (bool) $render_is_for_user;
	}
	
	
	public function renderSubject($name)
	{
		$subject = JMailHelper::cleanSubject($this->form->getParams()->get($name));
		$expanded = $this->replaceVariables($subject, false);
		return JMailHelper::cleanSubject($expanded);
	}
	
	
	public function renderBody($name)
	{
		$html = $this->renderBodyNoStyle($name);
		$emogrifier = new \Pelago\Emogrifier();
		$emogrifier->setHtml($html);
		$rawcss = FoxMessageTemplate::renderTemplate('user_email_tmpl.css');
		$emogrifier->setCss($rawcss);
		return $emogrifier->emogrify();
	}
	
	
	public function removeClassAttribute($html)
	{
		return preg_replace('/(<[a-z][a-z0-9]*[^=\'">]*)([^c]class[^=]*=[^\'"]*[\'"][a-z0-9\\s-_]*[\'"])([^>]*>)/i', '${1}${3}', $html);
	}
	
	
	private function renderBodyNoStyle($name)
	{
		$body = JMailHelper::cleanBody($this->form->getParams()->get($name));
		if (empty($body))
		{
			$body = $this->render_is_for_user ? FoxMessageTemplate::renderTemplate('user_email_tmpl.php') : FoxMessageTemplate::renderTemplate('admin_email_tmpl.php');
		}
		
		$body = $this->replaceVariables($body, true);
		return JMailHelper::cleanBody(FoxHtmlElem::create('div')->attr('dir', JFactory::getLanguage()->isRTL() ? 'rtl' : 'ltr')->html($body)->render());
	}
	
	
	public function replaceVariables($text, $is_html = false)
	{
		return $is_html ? preg_replace_callback('/{(.*?)}/', array($this, 'expandVariablesHttpSafe'), $text) : preg_replace_callback('/{(.*?)}/', array($this, 'expandVariables'), $text);
	}
	
	
	private function expandVariables($matches)
	{
		return $this->doExpandVariables($matches, false);
	}
	
	
	private function expandVariablesHttpSafe($matches)
	{
		return $this->doExpandVariables($matches, true);
	}
	
	
	private function doExpandVariables($matches, $http_safe)
	{
		$keyword = strtolower($matches[1]);
		$encode = true;
		switch ($keyword)
		{
			case 'user':
				$replace = JFactory::getUser()->get('username') or $replace = JText::_('COM_FOXCONTACT_NOT_LOGGED_IN');
				break;
			case 'date':
				$replace = JHtml::date('now', 'DATE_FORMAT_LC3', false);
				break;
			case 'time':
				$replace = JHtml::date('now', 'H:i', false);
				break;
			case 'field-table-full':
				$replace = $this->getFieldTable(true, true);
				$encode = false;
				break;
			case 'field-table-without-attachments':
				$replace = $this->getFieldTable(false, true);
				$encode = false;
				break;
			case 'field-table-without-client-info':
				$replace = $this->getFieldTable(true, false);
				$encode = false;
				break;
			case 'field-table':
				$replace = $this->getFieldTable(false, false);
				$encode = false;
				break;
			case 'client-ip-address':
				$replace = FoxDesignItemUserInfo::getIpAsText(FoxDesignItemUserInfo::getCurrentIp());
				break;
			case 'sitename':
				$replace = $this->getSiteName();
				break;
			case 'current-url':
				$replace = $this->getFormPageUri();
				break;
			case 'page-title':
				$replace = $this->getFormPageTitle();
				break;
			default:
				list($replace, $encode) = $this->getItemValue($item = $this->form->getDesign()->getFoxDesignItemByUniqueId($keyword));
		}
		
		if (!$encode && !$http_safe)
		{
			return '';
		}
		
		return $encode && $http_safe ? nl2br(FoxHtmlEncoder::encode($replace)) : $replace;
	}
	
	
	private function getFieldTable($include_attachments, $include_user_info)
	{
		$elems = FoxHtmlElem::create();
		foreach ($this->form->getDesign()->getItems() as $item)
		{
			switch ($item->getType())
			{
				case 'attachments':
				case 'user_info':
					break;
				default:
					list($value, $encode) = $this->getItemValue($item);
					$elems->append($this->getFieldRow($item->get('label'), $value, $encode));
					break;
			}
		
		}
		
		if ($include_attachments)
		{
			$item = $this->form->getDesign()->getFoxDesignItemByType('attachments');
			if (!is_null($item))
			{
				list($value, $encode) = $this->getItemValue($item);
				$elems->append($this->getFieldRow(JText::_('COM_FOXCONTACT_ATTACHMENTS'), $value, $encode));
			}
		
		}
		
		if ($include_user_info)
		{
			$elems->append($this->getFieldRow(JText::_('COM_FOXCONTACT_SITE_NAME'), $this->getSiteName()));
			$elems->append($this->getFieldRow(JText::_('COM_FOXCONTACT_CURRENT_URL'), $this->getFormPageLink(), false));
			$item = $this->form->getDesign()->getFoxDesignItemByType('user_info');
			if (!is_null($item))
			{
				$elems->append($this->getFieldRow(JText::_('COM_FOXCONTACT_CLIENT_DEVICE'), $item->getDeviceText()));
				$elems->append($this->getFieldRow(JText::_('COM_FOXCONTACT_CLIENT_OS'), $item->getOsText()));
				$elems->append($this->getFieldRow(JText::_('COM_FOXCONTACT_CLIENT_BROWSER'), $item->getBrowserText()));
				$elems->append($this->getFieldRow(JText::_('COM_FOXCONTACT_CLIENT_IP_ADDRESS'), $item->getIpText()));
			}
		
		}
		
		return FoxHtmlElem::create('dl')->attr('class', 'fields-list')->append($elems)->render();
	}
	
	
	private function getItemValue($item)
	{
		if (!is_null($item) && $item->canBeExported())
		{
			return $this->render_is_for_user ? array($item->getValueForUser(), !$item->isValueForUserHtml()) : array($item->getValueForAdmin(), !$item->isValueForAdminHtml());
		}
		
		return array('', false);
	}
	
	
	protected function getFieldRow($label, $value, $encode = true)
	{
		if (empty($value))
		{
			return '';
		}
		
		return FoxHtmlElem::create()->append(FoxHtmlElem::create('dt')->classes('field-title')->text(JFilterInput::getInstance()->clean($label)))->append(FoxHtmlElem::create('dd')->classes('field-content')->html($encode ? nl2br(FoxHtmlEncoder::encode(JFilterInput::getInstance()->clean($value))) : $value))->render();
	}
	
	
	private function getSiteName()
	{
		return JFactory::getConfig()->get('sitename');
	}
	
	
	private function getFormPageUri()
	{
		return $this->form->getDesign()->getFoxDesignItemSystem()->getFormPageUri();
	}
	
	
	private function getFormPageTitle()
	{
		return $this->form->getDesign()->getFoxDesignItemSystem()->getFormPageTitle();
	}
	
	
	private function getFormPageLink()
	{
		return $this->form->getDesign()->getFoxDesignItemSystem()->getFormPageLink();
	}

}