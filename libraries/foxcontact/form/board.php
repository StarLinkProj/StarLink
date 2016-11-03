<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxFormBoard
{
	const success = 'success';
	const info = 'info';
	const warning = 'warning';
	const error = 'error';
	private $data;
	
	public function __construct($data = array())
	{
		$this->data = empty($data) ? self::getDefaultData() : $data;
	}
	
	
	private static function getDefaultData()
	{
		return array('validated' => false, 'messages' => array(), 'messages_by_level' => array(FoxFormBoard::success => array(), FoxFormBoard::info => array(), FoxFormBoard::warning => array(), FoxFormBoard::error => array()), 'invalid_fileds' => array(), 'show_form_fileds' => true, 'delete_form_state_after_render' => false);
	}
	
	
	public function add($message, $level = FoxFormBoard::success, $show_one_time = false)
	{
		$msg = array('msg' => $message, 'lvl' => $level, 'sot' => $show_one_time);
		$this->data['messages_by_level'][$level][] = $msg;
		$this->data['messages'][] = $msg;
	}
	
	
	public function hasMessages()
	{
		return count($this->data['messages']) > 0;
	}
	
	
	public function getMessagesByLevel()
	{
		$messages_by_level = $this->data['messages_by_level'];
		foreach ($messages_by_level as $level => $messages)
		{
			if (count($messages) === 0)
			{
				unset($messages_by_level[$level]);
			}
			else
			{
				foreach ($messages as $index => $message)
				{
					$messages_by_level[$level][$index] = $message['msg'];
				}
			
			}
		
		}
		
		return $messages_by_level;
	}
	
	
	public function isValidated()
	{
		return (bool) $this->data['validated'];
	}
	
	
	public function setAsValidated()
	{
		$this->data['validated'] = true;
	}
	
	
	public function isFieldInvalid($unique_id)
	{
		return isset($this->data['invalid_fileds'][$unique_id]);
	}
	
	
	public function addInvalidField($unique_id)
	{
		$this->data['invalid_fileds'][$unique_id] = true;
	}
	
	
	public function getItemDecorationClass($unique_id)
	{
		if ($this->isValidated())
		{
			return !$this->isFieldInvalid($unique_id) ? 'success' : 'error';
		}
		
		return '';
	}
	
	
	public function getShowFormFields()
	{
		return (bool) $this->data['show_form_fileds'];
	}
	
	
	public function setShowFormFields($show_form_fileds)
	{
		$this->data['show_form_fileds'] = (bool) $show_form_fileds;
	}
	
	
	public function getDeleteFormStateAfterRender()
	{
		return (bool) $this->data['delete_form_state_after_render'];
	}
	
	
	public function setDeleteFormStateAfterRender($delete_form_state_after_render)
	{
		$this->data['delete_form_state_after_render'] = (bool) $delete_form_state_after_render;
	}
	
	
	public function setRedirectUrl($redirect_url)
	{
		$this->data['redirect_url'] = $redirect_url;
	}
	
	
	public function clear()
	{
		$this->data = self::getDefaultData();
	}
	
	
	public function onBeforeRender()
	{
		$url = isset($this->data['redirect_url']) ? $this->data['redirect_url'] : '';
		if (!empty($url))
		{
			header("refresh:5;url={$url}");
		}
	
	}
	
	
	public function onAfterRender()
	{
		foreach ($this->data['messages_by_level'] as $level => &$messages)
		{
			foreach ($messages as $index => $message)
			{
				if ($message['sot'] === true)
				{
					unset($messages[$index]);
				}
			
			}
		
		}
		
		foreach ($this->data['messages'] as $index => $message)
		{
			if ($message['sot'] === true)
			{
				unset($this->data['messages'][$index]);
			}
		
		}
	
	}
	
	
	public function &getData()
	{
		return $this->data;
	}

}