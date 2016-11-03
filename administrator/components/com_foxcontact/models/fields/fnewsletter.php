<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
JFormHelper::loadFieldClass('list');

class JFormFieldFNewsletter extends JFormFieldList
{
	public $type = 'FNewsletter';
	
	protected function getOptions()
	{
		$options = array();
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('extension_id'));
		$query->from($db->quoteName('#__extensions'));
		$query->where($db->quoteName('name') . ' = ' . $db->quote((string) $this->element['extension']));
		$db->setQuery($query);
		if (!$db->loadResult())
		{
			return '';
		}
		
		$query->clear();
		$query->select($db->quoteName((string) $this->element['key']) . ',' . $db->quoteName((string) $this->element['value']));
		$query->from($db->quoteName((string) $this->element['table']));
		$query->where($db->quoteName('published') . ' = ' . $db->quote('1'));
		$query->order($db->quoteName((string) $this->element['order']) . ' ASC');
		$db->setQuery($query);
		$items = $db->loadObjectlist() or $items = new stdClass();
		foreach ($items as $item)
		{
			$options[] = JHtml::_('select.option', $item->{(string) $this->element['key']}, $item->{(string) $this->element['value']});
		}
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}

}