<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 * Contributions by Arthur Plouet
 */
jimport('foxcontact.field.wizard');

class JFormFieldFText extends JFormField
{
	protected $type = 'FText';
	
	protected function getInput()
	{
		$size = $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$maxLength = $this->element['maxlength'] ? ' maxlength="' . (int) $this->element['maxlength'] . '"' : '';
		$class = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$readonly = (string) $this->element['readonly'] == 'true' ? ' readonly="readonly"' : '';
		$disabled = (string) $this->element['disabled'] == 'true' ? ' disabled="disabled"' : '';
		$onchange = $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';
		FoxFieldWizard::setWizardValue($this);
		FoxFieldWizard::setWizardPlaceholder($this);
		$placeholder = !empty($this->placeholder) ? ' placeholder="' . htmlspecialchars($this->placeholder) . '"' : '';
		return '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . $placeholder . $class . $size . $disabled . $readonly . $onchange . $maxLength . '/>';
	}

}