<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.design.base');
jimport('foxcontact.design.item_system');
jimport('foxcontact.design.item_antispam');
jimport('foxcontact.struct.manager');

class FoxDesignRoot extends FoxDesignBase
{
	private $uid = null, $data = null, $hash = null;
	private $items_map = array();
	private $items_lst = array();
	
	public static function parse($json)
	{
		$root = new FoxDesignRoot(FoxStructManager::check($json));
		$root->addItem(new FoxDesignItemSystem());
		$root->addItem(new FoxDesignItemAntispam());
		$root->hash = strval(md5($json));
		return $root;
	}
	
	
	public function setFormInfo($uid, &$data)
	{
		$this->uid = $uid;
		$this->data =& $data;
		foreach ($this->items_lst as $item)
		{
			$item->setData($this->data);
			$item->set('uid', $this->uid);
		}
	
	}
	
	
	public function addItem($item)
	{
		$item->setData($this->data);
		$item->set('uid', $this->uid);
		$this->items_map[strtolower($item->get('unique_id'))] = $item;
		$this->items_lst[] = $item;
	}
	
	
	public function getFoxDesignItemSystem()
	{
		return $this->getFoxDesignItemByType('system');
	}
	
	
	public function getFoxDesignItemByUniqueId($unique_id)
	{
		$lower_unique_id = strtolower($unique_id);
		return isset($this->items_map[$lower_unique_id]) ? $this->items_map[$lower_unique_id] : null;
	}
	
	
	public function getFoxDesignItemByType($type)
	{
		foreach ($this->items_lst as $item)
		{
			if ($item->getType() === $type)
			{
				return $item;
			}
		
		}
		
		return null;
	}
	
	
	public function getHash()
	{
		return $this->hash;
	}
	
	
	public function getItems()
	{
		return $this->items_lst;
	}

}