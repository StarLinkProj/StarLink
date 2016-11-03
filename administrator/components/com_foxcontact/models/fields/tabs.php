<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.lang');
JFormHelper::loadFieldClass('container');

class JFormFieldTabs extends JFormFieldContainer
{
	protected $type = 'Tabs';
	
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		static $resources = true;
		if ($resources)
		{
			$resources = false;
			JFactory::getDocument()->addStyleSheet(JUri::base(true) . '/components/com_foxcontact/css/' . (string) $element['css'] . '.css');
		}
		
		return parent::setup($element, $value, $group);
	}
	
	
	public function renderField($options = array())
	{
		$buffer = '<div class="tabbable tabs-left">' . '<ul class="nav nav-tabs">';
		foreach ($this->element->{'field'} as $tab)
		{
			$active = (bool) $tab['active'] ? 'class="active"' : '';
			$id = (string) $tab['id'];
			$label = JText::_((string) $tab['label']);
			$icon = (string) $tab['icon'];
			if (!empty($icon))
			{
				$icon = "<span class=\"icon-{$icon}\"></span> ";
			}
			
			$buffer .= "<li {$active}><a href=\"#{$id}\" data-toggle=\"tab\">{$icon}{$label}</a></li>";
		}
		
		$buffer .= '</ul>' . '<div class="tab-content">' . $this->getInput() . '</div>' . '</div>';
		return $buffer;
	}

}