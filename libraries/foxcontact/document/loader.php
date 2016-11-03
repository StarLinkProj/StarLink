<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.elem');

abstract class FoxDocumentLoader
{
	private static $instances = array();
	protected $document;
	protected $prefix;
	
	public static function getInstance($uid)
	{
		if (!isset(self::$instances[$uid]))
		{
			$config = JComponentHelper::getParams('com_foxcontact');
			$class = "FoxDocumentLoader{$config->get('resources_loading', 'Performance')}";
			self::$instances[$uid] = new $class($uid);
		}
		
		return self::$instances[$uid];
	}
	
	
	public function __construct($uid)
	{
		$this->document = JFactory::getDocument();
		$this->prefix = "index.php?option=com_foxcontact&task=loader.load&uid={$uid}";
	}
	
	
	public function addResource($values)
	{
		$slug = '';
		foreach ($values as $key => $value)
		{
			$slug .= "&{$key}={$value}";
		}
		
		$method = 'add' . ucwords($values['type']);
		$this->{$method}(JRoute::_("{$this->prefix}{$slug}"));
		return $this;
	}
	
	
	protected abstract function addCss($url);
	
	protected abstract function addJs($url);
}


class FoxDocumentLoaderPerformance extends FoxDocumentLoader
{
	
	protected function addCss($url)
	{
		$this->document->addStyleSheet($url);
	}
	
	
	protected function addJs($url)
	{
		$this->document->addScript($url);
	}

}


class FoxDocumentLoaderCompatibility extends FoxDocumentLoader
{
	
	protected function addCss($url)
	{
		$this->document->addCustomTag(FoxHtmlElem::create('link')->attr('rel', 'stylesheet')->attr('href', $url)->attr('type', 'text/css')->render());
	}
	
	
	protected function addJs($url)
	{
		$this->document->addCustomTag(FoxHtmlElem::create('script')->attr('src', $url)->attr('type', 'text/javascript')->render());
	}

}