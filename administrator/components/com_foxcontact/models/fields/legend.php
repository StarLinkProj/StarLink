<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class JFormFieldLegend extends JFormField
{
	protected $type = 'Legend';
	
	protected function getInput()
	{
		return '';
	}
	
	
	public function renderField($options = array())
	{
		$class = (string) $this->element['class'];
		if (!empty($class))
		{
			$class = 'class="' . $class . '">';
		}
		
		$icon = (string) $this->element['icon'];
		if (!empty($icon))
		{
			$icon = "<span class=\"icon-{$icon}\"></span> ";
		}
		
		$text = JText::_((string) $this->element);
		$help = (string) $this->element['help'];
		if (!empty($help))
		{
			$help = "<a href=\"{$help}\" target=\"_blank\"><span class=\"icon-question-circle\"></span></a>";
		}
		
		return "<fieldset {$class}><legend>{$icon}{$text}{$help}</legend></fieldset>";
	}

}