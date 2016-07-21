<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.resource');

class FoxDesignItemSubmit extends FoxDesignItem
{
	private $cache = array();
	
	public function addResources($document)
	{
		$document->addScript(FoxHtmlResource::path('/media/com_foxcontact/js/buttons', 'js'));
	}
	
	
	public function update($post_data)
	{
	}
	
	
	public function canBeExported()
	{
		return false;
	}
	
	
	public function getIconClass($type)
	{
		$icon = $this->get("{$type}.icon");
		return !empty($icon) ? 'with-icon' : '';
	}
	
	
	public function getIconStyle($type)
	{
		$icon = $this->get("{$type}.icon");
		$base = JUri::root(true);
		return !empty($icon) ? "background-image: url({$base}/media/com_foxcontact/images/{$type}/{$icon});" : '';
	}
	
	
	public function hasImage($type)
	{
		$value = $this->get("{$type}.image");
		return !empty($value);
	}
	
	
	public function getImageUrl($type)
	{
		if (!isset($this->cache["{$type}:url"]))
		{
			$image = $this->get("{$type}.image");
			$base = JUri::root(true);
			$this->cache["{$type}:url"] = "{$base}/media/com_foxcontact/images/buttons/{$type}/{$image}";
		}
		
		return $this->cache["{$type}:url"];
	}
	
	
	public function getImageWidth($type)
	{
		$size = $this->getImageSize($type);
		return $size[0];
	}
	
	
	public function getImageHeight($type)
	{
		$size = $this->getImageSize($type);
		return $size[1];
	}
	
	
	private function getImageSize($type)
	{
		if (!isset($this->cache["{$type}:size"]))
		{
			$image = $this->get("{$type}.image");
			$base = JPATH_ROOT;
			$size = @getimagesize("{$base}/media/com_foxcontact/images/buttons/{$type}/{$image}") or $size = array(0, 0);
			$this->cache["{$type}:size"] = $size;
		}
		
		return $this->cache["{$type}:size"];
	}

}