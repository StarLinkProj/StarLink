<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxDesignItemCheckbox extends FoxDesignItem
{
	
	public function getRenderMode($form)
	{
		switch ($this->get('label_position'))
		{
			case 'after':
				return 'after';
			case 'before':
				if ($form->getDesign()->get('option.label.position') === 'inside')
				{
					return $form->getDesign()->get('option.form.render') === 'inline' ? 'before_force_label' : 'after';
				}
				
				return 'before';
			default:
				return 'after';
		}
	
	}
	
	
	public function update($post_data)
	{
		$this->setValue(isset($post_data[$this->get('unique_id')]) ? JText::_('JYES') : JText::_('JNO'));
	}
	
	
	protected function getDefaultValue()
	{
		return $this->get('preselected', false) ? JText::_('JYES') : null;
	}
	
	
	protected function isValueEmpty($value)
	{
		return $value !== JText::_('JYES');
	}

}