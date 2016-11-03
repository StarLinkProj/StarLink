<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.form.model');
jimport('foxcontact.action.target');

class FoxContactControllerForm extends JControllerLegacy
{
	
	public function reset()
	{
		$post = JFactory::getApplication()->input->post;
		$form = FoxFormModel::getFormByUid($post->get('uid'));
		$this->doRedirect($form, true, $this->getFormUrlWithFragment($post, $form));
	}
	
	
	public function send()
	{
		$post = JFactory::getApplication()->input->post;
		$form = FoxFormModel::getFormByUid($post->get('uid'));
		$board = $form->getBoard();
		$post_data = $post->get('fox_form', array(), 'array');
		$post_data = $post_data[$form->getUid()];
		$board->clear();
		$form->update($post_data);
		$valid = $form->validate($messages);
		$board->setAsValidated();
		if (!$valid)
		{
			foreach ($messages as $message)
			{
				$board->addInvalidField($message['src']);
				$board->add($message['msg'], $message['lvl']);
			}
			
			$this->doRedirect($form, false, $this->getFormUrlWithFragment($post, $form));
		}
		
		$target = new FoxActionTarget();
		$target->setUrl($this->getFormUrlWithFragment($post, $form), true);
		if (!$form->process($target))
		{
			if (!$board->hasMessages())
			{
				$board->add(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), FoxFormBoard::error);
			}
			
			$this->doRedirect($form, false, $this->getFormUrlWithFragment($post, $form));
		}
		
		if ($target->isImmediate())
		{
			$this->doRedirect($form, true, $target->getUrl());
		}
		
		if ($target->hasReturnUrl())
		{
			$board->setRedirectUrl($target->getUrl());
		}
		
		$board->setShowFormFields(false);
		$board->setDeleteFormStateAfterRender(true);
		$this->doRedirect($form, false, $this->getFormUrlWithFragment($post, $form));
	}
	
	
	private function doRedirect($form, $delete_form_state, $url)
	{
		$delete_form_state ? $form->delete() : $form->save();
		JFactory::getApplication()->redirect($url);
	}
	
	
	private function getFormUrlWithFragment($post, $form)
	{
		return "{$post->get('fox_form_page_uri', null, 'raw')}#fox_{$form->getUid()}";
	}

}