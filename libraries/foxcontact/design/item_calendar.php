<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.resource');

class FoxDesignItemCalendar extends FoxDesignItem
{
	
	public function addResources($document)
	{
		$document->addScript(FoxHtmlResource::path('/media/com_foxcontact/js/calendar', 'js'));
		$document->addStyleSheet(FoxHtmlResource::path('/media/com_foxcontact/css/calendar', 'css', false));
	}
	
	
	public function haveDate()
	{
		return $this->get('mode') === 'datetime' || $this->get('mode') === 'date';
	}
	
	
	public function haveTime()
	{
		return $this->get('mode') === 'datetime' || $this->get('mode') === 'time';
	}
	
	
	public function haveDateAndTime()
	{
		return $this->get('mode') === 'datetime';
	}
	
	
	public function getFormat()
	{
		return ($this->haveDate() ? JText::_('DATE_FORMAT_LC') : '') . ($this->haveTime() ? ' H:i' : '');
	}

}