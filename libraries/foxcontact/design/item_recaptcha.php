<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.recaptcha');

class FoxDesignItemRecaptcha extends FoxDesignItem
{
	protected $captcha = null;
	
	protected function init()
	{
		$this->captcha = FoxJoomlaRecaptcha::getInstance($this->getItemId());
	}
	
	
	public function getState()
	{
		if (!$this->captcha->isEnable())
		{
			return 'disabled';
		}
		
		$board = FoxFormModel::getFormByUid($this->get('uid'))->getBoard();
		return !$board->isValidated() || $board->isFieldInvalid($this->get('unique_id')) ? 'not_valid' : 'valid';
	}
	
	
	public function getJCaptcha()
	{
		return $this->captcha;
	}
	
	
	public function getLabelForId()
	{
		return '';
	}
	
	
	public function getValue()
	{
		return isset($this->data[$this->get('unique_id')]) ? $this->data[$this->get('unique_id')] : $this->getDefaultValue();
	}
	
	
	public function getValueAsText()
	{
		return (string) $this->getValue();
	}
	
	
	public function hasValue()
	{
		$value = $this->getValue();
		return !empty($value);
	}
	
	
	protected function check($value, &$messages)
	{
		$secure_form_id = $this->getSecureFormId();
		if ($value !== $secure_form_id && !$this->captcha->checkAnswer($value))
		{
			$messages[] = $this->getMessage(JText::sprintf('COM_FOXCONTACT_ERR_INVALID_VALUE', JText::_('COM_FOXCONTACT_RECAPTCHA_SOLUTION')));
		}
		else
		{
			$this->setValue($secure_form_id);
		}
	
	}
	
	
	private function getSecureFormId()
	{
		$form = FoxFormModel::getFormByUid($this->get('uid'));
		return md5("[{$form->getInstanceId()}:{$this->getItemId()}]");
	}
	
	
	public function canBeExported()
	{
		return false;
	}

}