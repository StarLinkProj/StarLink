<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.captcha');

class FoxDesignItemCaptcha extends FoxDesignItem
{
	
	protected function init()
	{
		$this->set('required', true);
	}
	
	
	public function getLabelForId()
	{
		return "{$this->getItemId()}-answer";
	}
	
	
	private function canRenderCaptchaImage()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)->select($db->quoteName('value'))->from($db->quoteName('#__foxcontact_settings'))->where("{$db->quoteName('name')} = {$db->quote('captchadrawer')}");
		$method = (string) $db->setQuery($query)->loadResult();
		return !empty($method) && $method !== 'disabled';
	}
	
	
	public function getState()
	{
		if (!$this->canRenderCaptchaImage())
		{
			return 'disabled';
		}
		
		$board = FoxFormModel::getFormByUid($this->get('uid'))->getBoard();
		return !$board->isValidated() || $board->isFieldInvalid($this->get('unique_id')) ? 'not_valid' : 'valid';
	}
	
	
	public function getAnswer()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)->select($db->quoteName('answer'))->from($db->quoteName('#__foxcontact_captcha'))->where("{$db->quoteName('session_id')} = {$db->quote(JFactory::getSession()->getId())}")->where("{$db->quoteName('form_uid')} = {$db->quote($this->get('uid'))}");
		return (string) $db->setQuery($query)->loadResult();
	}
	
	
	public function setAnswer($answer)
	{
		$db = JFactory::getDbo();
		$table = $db->quoteName('#__foxcontact_captcha');
		$session_id_col = $db->quoteName('session_id');
		$form_uid_col = $db->quoteName('form_uid');
		$date_col = $db->quoteName('date');
		$answer_col = $db->quoteName('answer');
		$session_id_val = $db->quote(JFactory::getSession()->getId());
		$form_uid_val = $db->quote($this->get('uid'));
		$date_val = $db->quote(time());
		$answer_val = $db->quote($answer);
		self::deleteOldAnswers();
		$db->setQuery("REPLACE INTO {$table} ({$session_id_col}, {$form_uid_col}, {$date_col}, {$answer_col}) VALUES ({$session_id_val}, {$form_uid_val}, {$date_val}, {$answer_val});")->execute();
	}
	
	
	private static function deleteOldAnswers()
	{
		$db = JFactory::getDbo();
		$limit = time() - JFactory::getConfig()->get('lifetime', 900) * 60;
		$query = $db->getQuery(true)->delete($db->quoteName('#__foxcontact_captcha'))->where("{$db->quoteName('date')} < {$db->quote($limit)}");
		return $db->setQuery($query)->execute();
	}
	
	
	protected function check($value, &$messages)
	{
		$answer = $this->getAnswer();
		if (empty($answer) || empty($value) || self::faultTolerance($value) !== self::faultTolerance($answer))
		{
			$messages[] = $this->getMessage(JText::sprintf('COM_FOXCONTACT_ERR_INVALID_VALUE', $this->get('label')));
		}
	
	}
	
	
	private static function faultTolerance($string)
	{
		$string = strtolower($string);
		$string = preg_replace('/[l1]/', 'i', $string);
		$string = preg_replace('/[0]/', 'o', $string);
		$string = preg_replace('/[q9]/', 'g', $string);
		$string = preg_replace('/[5]/', 's', $string);
		$string = preg_replace('/[8]/', 'b', $string);
		return $string;
	}
	
	
	public function canBeExported()
	{
		return false;
	}

}