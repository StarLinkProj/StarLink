<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class JFormFieldSearchBox extends JFormField
{
	protected $type = 'SearchBox';
	
	protected function getInput()
	{
		$html = '<div class="input-append">';
		$maxlength = (string) $this->element['maxlength'];
		$placeholder = (string) $this->element['placeholder'];
		$attributes = (!empty($this->class) ? 'class="' . $this->class . '" ' : '') . (!empty($maxlength) ? 'maxlength="' . $maxlength . '" ' : '') . (!empty($placeholder) ? 'placeholder="' . JText::_($placeholder) . '" ' : '');
		$html .= '<input ' . 'type="text" ' . 'name="' . $this->name . '" ' . 'id="' . $this->id . '" ' . 'value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" ' . $attributes . '/>';
		$html .= '<button type="submit" class="btn hasTooltip" title=""><i class="icon-search"></i></button></div>';
		return $html;
	}

}