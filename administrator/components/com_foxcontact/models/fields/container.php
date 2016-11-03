<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class JFormFieldContainer extends JFormField
{
	protected $type = 'Container';
	
	protected function getInput()
	{
		$buffer = '';
		foreach ($this->element->{'field'} as $element)
		{
			$name = (string) $element['name'];
			$value = $this->form->getValue($name, 'params', (string) $element['default']);
			$name = (string) $element['type'];
			$type = "JFormField{$name}";
			JFormHelper::loadFieldClass($name);
			$field = new $type($this->form);
			$field->setup($element, $value, 'params');
			$buffer .= $field->renderField() . PHP_EOL;
		}
		
		return $buffer;
	}
	
	
	public function renderField($options = array())
	{
		$element = (string) $this->element['element'];
		$class = (string) $this->element['class'];
		if (!empty($class))
		{
			$class = 'class="' . $class . '"';
		}
		
		return "<{$element} {$class}>" . $this->getInput() . "</{$element}>";
	}

}