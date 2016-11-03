<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
JFormHelper::loadFieldClass('spacer');

class JFormFieldFSpacer extends JFormFieldSpacer
{
	protected $type = 'FSpacer';
	
	protected function getInput()
	{
		$url = (string) $this->element['url'];
		return '<a target="_blank" class="spacer" href="' . $url . '">' . JText::_((string) $this->element['label']) . '</a>';
	}
	
	
	public function renderField($options = array())
	{
		return '<div class="control-group"><div class="controls">' . $this->getInput() . '</div></div>';
	}

}