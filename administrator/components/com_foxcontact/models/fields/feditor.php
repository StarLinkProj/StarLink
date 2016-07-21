<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
JFormHelper::loadFieldClass('editor');
jimport('foxcontact.message.template');

class JFormFieldFEditor extends JFormFieldEditor
{
	public $type = 'FEditor';
	
	protected function getInput()
	{
		if (empty($this->value))
		{
			$this->value = $this->getDefaultHtmlValue();
		}
		
		return parent::getInput();
	}
	
	
	protected function getDefaultHtmlValue()
	{
		$template = (string) $this->element['template'];
		return FoxMessageTemplate::renderTemplate("{$template}.php");
	}

}