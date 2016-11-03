<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('joomla.application.component.modellist');
JLoader::register('FoxContactModelEnquiries', JPATH_COMPONENT . '/models/enquiries.php');

class FoxContactModelExport extends FoxContactModelEnquiries
{
	
	public function getItems()
	{
		$this->context = 'com_foxcontact.enquiries';
		$this->populateState();
		$query = $this->_getListQuery();
		$this->_db->setQuery($query);
		$items = $this->_db->loadAssocList();
		foreach ($items as &$item)
		{
			$fields = json_decode($item['fields']);
			foreach ($fields as $field)
			{
				$item[$field[1]] = str_replace(array("\r", "\n"), ' ', $field[2]);
			}
			
			unset($item['exported']);
			unset($item['fields']);
		}
		
		return $items;
	}
	
	
	public function mark($items)
	{
		$ids = array();
		foreach ($items as $item)
		{
			$ids[] = $item['id'];
		}
		
		if (!empty($ids))
		{
			$query = $this->_db->getQuery(true);
			$query->update('#__foxcontact_enquiries');
			$query->set('exported = 1');
			$query->where('id IN (' . implode(',', $ids) . ')');
			$this->_db->setQuery($query);
			$this->_db->execute();
		}
	
	}

}