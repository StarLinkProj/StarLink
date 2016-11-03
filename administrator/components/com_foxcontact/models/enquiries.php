<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxContactModelEnquiries extends JModelList
{
	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array('id', 'a.id', 'date', 'a.date', 'exported', 'a.exported');
		}
		
		parent::__construct($config);
	}
	
	
	protected function getListQuery()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->select($this->getState('list.select', 'a.id AS id,' . 'a.form_id AS form_id,' . 'a.date AS date,' . 'a.exported AS exported,' . 'a.ip AS ip,' . 'a.url AS url,' . 'a.fields fields'));
		$query->from($db->quoteName('#__foxcontact_enquiries') . ' AS a');
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$query->where('a.fields LIKE ' . $db->quote('%' . $db->escape($search, true) . '%'));
		}
		
		$exported = (int) $this->getState('filter.exported');
		$query->where('a.exported <= ' . $exported);
		$initial_date = $this->getState('filter.initial_date');
		if (!empty($initial_date))
		{
			$query->where('a.date >= ' . $db->quote($initial_date));
		}
		
		$final_date = $this->getState('filter.final_date');
		if (!empty($final_date))
		{
			$query->where('a.date <= ' . $db->quote($final_date));
		}
		
		$forms = $this->getState('filter.forms');
		if (!empty($forms))
		{
			$forms = implode(',', $db->quote($forms));
			$query->where('form_id IN (' . $forms . ')');
		}
		
		$order = $this->state->get('list.fullordering', 'a.date DESC');
		$query->order($db->escape($order));
		return $query;
	}
	
	
	public function getItems()
	{
		$query = $this->_getListQuery();
		$items = $this->_getList($query, $this->getStart(), (int) $this->getState('list.limit'));
		$db = JFactory::getDbo();
		$query->clear();
		$query->select('id as value, title as text');
		$query->from('#__menu');
		$query->where('link LIKE ' . $db->quote('%option=com_foxcontact&view=foxcontact%'));
		$db->setQuery($query);
		$components = $db->loadAssocList('value');
		$query->clear();
		$query->select('-id as value, title as text');
		$query->from('#__modules');
		$query->where('module = ' . $db->quote('mod_foxcontact'));
		$db->setQuery($query);
		$modules = $db->loadAssocList('value');
		$forms = $components + $modules;
		foreach ($items as &$item)
		{
			$item->from_data = array('', '');
			$from_data_count = 0;
			$fields = json_decode($item->fields);
			foreach ($fields as $field)
			{
				switch ($field[0])
				{
					case 'sender':
						$item->from_data[$from_data_count++] = $field[2];
						break;
					case 'sender_name':
					case 'name':
						$item->from_data[0] = $field[2];
						break;
					case 'sender_email':
					case 'email':
						$item->from_data[1] = $field[2];
						break;
				}
			
			}
			
			$item->class = $item->exported ? ' exported' : '';
			if (isset($forms[$item->form_id]))
			{
				$item->form = $forms[$item->form_id]['text'];
			}
			else
			{
				$item->form = JText::_('JLIB_UNKNOWN');
			}
		
		}
		
		return $items;
	}

}