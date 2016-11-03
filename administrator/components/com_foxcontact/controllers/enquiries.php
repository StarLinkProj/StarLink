<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxContactControllerEnquiries extends JControllerAdmin
{
	protected $text_prefix = 'COM_FOXCONTACT';
	
	public function getModel($name = 'Enquiry', $prefix = 'FoxContactModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	
	public function export()
	{
		$model = $this->getModel('Export', 'FoxContactModel', array('ignore_request' => true));
		$items = $model->getItems();
		$this->csv($items);
		$model->mark($items);
		JFactory::getApplication()->close();
	}
	
	
	protected function csv($items)
	{
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . JText::_('COM_FOXCONTACT_SUBMENU_ENQUIRIES') . '.csv"');
		$delimiter = "\t";
		$enclosure = '"';
		$fp = fopen('php://output', 'w');
		if ((bool) count($items))
		{
			$keys = array_keys($items[0]);
			fputcsv($fp, $keys, $delimiter, $enclosure);
		}
		
		foreach ($items as $item)
		{
			fputcsv($fp, $item, $delimiter, $enclosure);
		}
		
		fclose($fp);
	}

}