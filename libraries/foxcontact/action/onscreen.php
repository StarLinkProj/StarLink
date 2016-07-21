<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.action.base');
jimport('foxcontact.html.link');

class FoxActionOnScreen extends FoxActionBase
{
	
	public function process($target)
	{
		$show_onscreen_message = (bool) $this->params->get('show_onscreen_message', 1);
		if ($show_onscreen_message)
		{
			$this->form->getBoard()->add($this->getMessageHtml(), FoxFormBoard::success);
			$target->setUrl(null, false);
		}
		
		if ((int) $this->params->get('do_onscreen_redirect', 0))
		{
			$target->setUrl($this->getTargetUrl(), !$show_onscreen_message);
		}
		
		return true;
	}
	
	
	private function getMessageHtml()
	{
		return $this->form->getMessageRender()->replaceVariables($this->params->get('onscreen_message_content'), true);
	}
	
	
	private function getTargetUrl()
	{
		$menu = JFactory::getApplication()->getMenu()->getItem((int) $this->params->get('onscreen_redirect_item', 0));
		return !is_null($menu) ? JRoute::_(FoxHtmlLink::getMenuLink($menu), false) : JRoute::_('index.php', false);
	}

}