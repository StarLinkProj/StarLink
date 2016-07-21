<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.log');

class FoxDesignItemAntispam extends FoxDesignItem
{
	
	public function __construct($value = array())
	{
		parent::__construct(array_merge_recursive($value, array('type' => 'antispam', 'unique_id' => 'antispam')));
		JLog::addLogger(array('text_file' => 'foxcontact.php', 'text_entry_format' => "{DATE}\t{TIME}\t{PRIORITY}\t{CATEGORY}\t{MESSAGE}"), JLog::ALL, array('spam'));
	}
	
	
	public function update($post_data)
	{
	}
	
	
	public function canBeExported()
	{
		return false;
	}
	
	
	protected function check($value, &$messages)
	{
		$form = FoxFormModel::getFormByUid($this->get('uid'));
		$spam_words = $this->getSpamWords($form);
		if (count($spam_words) !== 0)
		{
			$text = $this->getTextToCheck($form);
			foreach ($spam_words as $word)
			{
				if (stripos($text, trim($word)) !== false)
				{
					$messages[] = $this->getMessage($form->getParams()->get('spam_detected_text'), FoxFormBoard::warning);
					$this->log($form);
					break;
				}
			
			}
		
		}
	
	}
	
	
	private function getSpamWords($form)
	{
		$disabled = !(bool) $form->getParams()->get('spam_check', 0);
		$spam_words = trim($form->getParams()->get('spam_words', ''));
		if ($disabled || empty($spam_words))
		{
			return array();
		}
		
		return explode(',', $spam_words);
	}
	
	
	private function getTextToCheck($form)
	{
		$text = '';
		foreach ($form->getDesign()->getItems() as $item)
		{
			if ($item->getType() === 'text_area')
			{
				$text .= " {$item->getValue()}";
			}
		
		}
		
		return $text;
	}
	
	
	protected function log($form)
	{
		if ((bool) $form->getParams()->get('spam_log', true))
		{
			FoxLog::add('Spam attempt blocked: ' . json_encode($form->getData()), JLog::INFO, 'spam');
		}
	
	}

}