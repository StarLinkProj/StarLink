<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.diagnostic.conflicting');
jimport('foxcontact.html.elem');

class FoxDesignItemSystem extends FoxDesignItem
{
	
	public function __construct($value = array())
	{
		parent::__construct(array_merge_recursive($value, array('type' => 'system', 'unique_id' => 'System')));
	}
	
	
	public function onBeforeRender()
	{
		$uid = $this->get('uid');
		FoxDiagnosticConflicting::check($uid);
	}
	
	
	public function update($post_data)
	{
		$post = JFactory::getApplication()->input->post;
		$this->setValue(array('title' => $post->get('fox_form_page_title', null, 'raw'), 'uri' => $post->get('fox_form_page_uri', null, 'raw')));
	}
	
	
	public function canBeExported()
	{
		return false;
	}
	
	
	public function getFormPageTitle()
	{
		$values = $this->getValue();
		return (string) $values['title'];
	}
	
	
	public function getFormPageUri()
	{
		$values = $this->getValue();
		return (string) $values['uri'];
	}
	
	
	public function getFormPageLink()
	{
		return FoxHtmlElem::create('a')->attr('href', $this->getFormPageUri())->classes('field-table-href')->text($this->getFormPageTitle())->render();
	}

}