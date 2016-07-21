<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.action.base');
jimport('foxcontact.design.item_user_info');
jimport('foxcontact.joomla.log');

class FoxActionDatabase extends FoxActionBase
{
	
	public function process($target)
	{
		if (!(bool) $this->params->get('delivery_db', true))
		{
			return true;
		}
		
		$oid = $this->form->getScope() === 'component' ? +$this->form->getId() : -$this->form->getId();
		$date = JFactory::getDate()->toSql();
		$ip = FoxDesignItemUserInfo::getCurrentIp();
		$url = $this->form->getDesign()->getFoxDesignItemSystem()->getFormPageUri();
		$data_json = $this->getDataJson();
		$result = $this->insert($oid, $date, $ip, $url, $data_json);
		if (!$result)
		{
			FoxLog::add('Enquiry NOT saved to the database.', JLog::ERROR, 'action');
			$this->form->getBoard()->add(JText::_('COM_FOXCONTACT_ERR_DATABASE'), FoxFormBoard::error);
		}
		else
		{
			FoxLog::add('Enquiry saved to the database.', JLog::INFO, 'action');
		}
		
		return $result;
	}
	
	
	private function insert($oid, $date, $ip, $uri, $data_json)
	{
		try
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)->insert($db->quoteName('#__foxcontact_enquiries'))->set($db->quoteName('form_id') . '=' . $db->quote($oid))->set($db->quoteName('date') . '=' . $db->quote($date))->set($db->quoteName('ip') . '=' . $db->quote($ip))->set($db->quoteName('url') . '=' . $db->quote($uri))->set($db->quoteName('fields') . '=' . $db->quote($data_json));
			$result = (bool) $db->setQuery($query)->execute();
		}
		catch (Exception $e)
		{
			FoxLog::add("Unable to save the enquiry into the database. Database error details: {$e->getMessage()}", JLog::ERROR, 'action');
			$result = false;
		}
		
		return $result;
	}
	
	
	private function getDataJson()
	{
		$data = array();
		foreach ($this->form->getDesign()->getItems() as $item)
		{
			if ($item->canBeExported() && $item->hasValue())
			{
				$type = $item->getType();
				$label = $item->get('label');
				$unique_id = $item->get('unique_id');
				$value = $item->getValueAsText();
				$data[] = array($type, !empty($label) ? $label : $unique_id, $value);
			}
		
		}
		
		return json_encode($data);
	}

}