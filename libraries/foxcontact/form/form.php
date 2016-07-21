<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.design.root');
jimport('foxcontact.form.board');
jimport('foxcontact.action.target');
jimport('foxcontact.message.render');
jimport('foxcontact.document.loader');

class FoxFormForm
{
	private static $action_names = array('jmessenger', 'database', 'newsletter_plugin', 'newsletter_acymailing', 'newsletter_jnews', 'email_admin', 'email_user', 'onscreen');
	private static $resources = array();
	private $scope, $id, $uid, $params, $version, $design;
	private $iid;
	private $data, $board;
	private $actions, $render;
	
	public function __construct($scope, $id, $params, $version)
	{
		$this->scope = $scope;
		$this->id = $id;
		$this->uid = substr($scope, 0, 1) . $id;
		$this->params = $params;
		$this->version = $version;
		$this->design = FoxDesignRoot::parse($params->get('design'));
		$default_data = array('hash' => $this->design->getHash());
		$saved_data = JFactory::getSession()->get("form_{$this->uid}", $default_data, 'com_foxcontact');
		$this->iid = !isset($saved_data['iid']) ? uniqid('F', true) : $saved_data['iid'];
		if (!isset($saved_data['hash']) || $saved_data['hash'] !== $this->design->getHash())
		{
			$this->delete();
			$saved_data = $default_data;
		}
		
		$this->data = isset($saved_data['data']) ? $saved_data['data'] : array();
		$this->board = new FoxFormBoard(isset($saved_data['board']) ? $saved_data['board'] : array());
		$this->design->setFormInfo($this->uid, $this->data);
	}
	
	
	public function getScope()
	{
		return $this->scope;
	}
	
	
	public function getId()
	{
		return $this->id;
	}
	
	
	public function getUid()
	{
		return $this->uid;
	}
	
	
	public function getParams()
	{
		return $this->params;
	}
	
	
	public function getVersion()
	{
		return $this->version;
	}
	
	
	public function getDesign()
	{
		return $this->design;
	}
	
	
	public function getInstanceId()
	{
		return $this->iid;
	}
	
	
	public function &getData()
	{
		return $this->data;
	}
	
	
	public function getName()
	{
		$name = $this->getDesign()->getFoxDesignItemByType('name');
		return !is_null($name) ? $name->getValue() : '';
	}
	
	
	public function getEmail()
	{
		$email = $this->getDesign()->getFoxDesignItemByType('email');
		return !is_null($email) ? $email->getValue() : '';
	}
	
	
	public function getBoard()
	{
		return $this->board;
	}
	
	
	public function update($post_data)
	{
		foreach ($this->getDesign()->getItems() as $item)
		{
			$item->update($post_data);
		}
	
	}
	
	
	public function onBeforeRender()
	{
		$this->addSystemResources();
		$this->addFormResources();
		foreach ($this->getDesign()->getItems() as $item)
		{
			$this->addItemResources($item);
			$item->onBeforeRender();
		}
		
		if (strpos($this->version, 'beta'))
		{
			$this->getBoard()->add(JText::_('COM_FOXCONTACT_WARNING_BETA_VERSION'), FoxFormBoard::info, true);
		}
		
		$this->board->onBeforeRender();
	}
	
	
	private function addSystemResources()
	{
		if (!isset(self::$resources['form']))
		{
			JHtml::_('jquery.framework');
			JHtml::_('bootstrap.framework');
			JHtml::_('behavior.keepalive');
			FoxDocumentLoader::getInstance($this->getUid())->addResource(array('root' => 'components', 'name' => 'foxtext', 'type' => 'js'));
			self::$resources['form'] = false;
		}
	
	}
	
	
	private function addFormResources()
	{
		$fox_document_loader = FoxDocumentLoader::getInstance($this->getUid());
		$fox_document_loader->addResource(array('root' => 'media', 'name' => 'foxcontact', 'type' => 'css'));
		$stylesheet = $this->getDesign()->get('option.form.style', 'bootstrap.css');
		$stylesheet = preg_replace('/\\.[^.\\s]{3,4}$/', '', $stylesheet);
		if (!empty($stylesheet))
		{
			$fox_document_loader->addResource(array('root' => 'components', 'name' => $stylesheet, 'type' => 'css'));
		}
	
	}
	
	
	private function addItemResources($item)
	{
		if (!isset(self::$resources[$item->getType()]))
		{
			$item->addResources(JFactory::getDocument());
			self::$resources[$item->getType()] = true;
		}
	
	}
	
	
	public function onAfterRender()
	{
		foreach ($this->getDesign()->getItems() as $item)
		{
			$item->onAfterRender();
		}
		
		$this->board->onAfterRender();
		if ($this->board->getDeleteFormStateAfterRender())
		{
			$this->delete();
		}
		else
		{
			if ($this->board->isValidated())
			{
				$this->save();
			}
		
		}
	
	}
	
	
	public function validate(&$messages)
	{
		$messages = array();
		foreach ($this->getDesign()->getItems() as $item)
		{
			$item->validate($messages);
		}
		
		return count($messages) === 0;
	}
	
	
	public function process($target)
	{
		foreach ($this->getActions() as $action)
		{
			if (!$action->process($target))
			{
				return false;
			}
		
		}
		
		return true;
	}
	
	
	private function getActions()
	{
		if (is_null($this->actions))
		{
			$this->actions = array();
			foreach (self::$action_names as $action_name)
			{
				jimport("foxcontact.action.{$action_name}");
				$class_name = 'FoxAction' . str_replace('_', '', $action_name);
				$this->actions[] = new $class_name($this, $this->params);
			}
		
		}
		
		return $this->actions;
	}
	
	
	public function getMessageRender($render_is_for_user = true)
	{
		if (is_null($this->render))
		{
			$this->render = new FoxMessageRender($this);
		}
		
		$this->render->setRenderIsForUser($render_is_for_user);
		return $this->render;
	}
	
	
	public function save()
	{
		JFactory::getSession()->set("form_{$this->uid}", array('iid' => $this->iid, 'hash' => $this->design->getHash(), 'data' => $this->getData(), 'board' => $this->board->getData()), 'com_foxcontact');
	}
	
	
	public function delete()
	{
		JFactory::getSession()->clear("form_{$this->uid}", 'com_foxcontact');
	}

}