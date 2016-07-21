<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.encoder');

class FoxHtmlElem
{
	protected $type;
	protected $attributes = array();
	protected $classes = array();
	protected $children = array();
	
	public static function create($type = null)
	{
		$safe_type = strtolower(!empty($type) ? $type : '-');
		switch ($safe_type)
		{
			case '-':
				return new FoxHtmlTrasparentContainerElem($type);
			case 'input':
			case 'img':
			case 'hr':
			case 'br':
			case 'meta':
			case 'link':
				return new FoxHtmlAutoCloseElem($type);
			default:
				return new FoxHtmlElem($type);
		}
	
	}
	
	
	protected function __construct($type)
	{
		$this->type = strtolower($type);
	}
	
	
	public function conditional($condition, $generator)
	{
		if ($condition)
		{
			$this->append($generator());
		}
		
		return $this;
	}
	
	
	public function appends($sources, $generator)
	{
		foreach ($sources as $index => $source)
		{
			$this->append($generator($source, $index));
		}
		
		return $this;
	}
	
	
	public function append($elem)
	{
		if (!empty($elem))
		{
			$this->children[] = $elem;
		}
		
		return $this;
	}
	
	
	public function isEmpty()
	{
		return count($this->children) === 0;
	}
	
	
	public function text($text)
	{
		return $this->html(FoxHtmlEncoder::encode($text));
	}
	
	
	public function html($html)
	{
		$this->children = array($html);
		return $this;
	}
	
	
	public function attr($name, $value = null)
	{
		return $this->setAttr(strtolower($name), !is_null($value) ? (string) $value : null);
	}
	
	
	protected function setAttr($name, $value = null)
	{
		$this->type === 'label' && $name === 'for' && empty($value) ? $this->remAttr($name) : ($this->attributes[$name] = $value);
		return $this;
	}
	
	
	protected function setBoolAttr($name, $value)
	{
		return $value ? $this->setAttr($name) : $this->remAttr($name);
	}
	
	
	protected function remAttr($name)
	{
		unset($this->attributes[$name]);
		return $this;
	}
	
	
	public function classes($classes)
	{
		if (!empty($classes))
		{
			foreach (explode(' ', $classes) as $class)
			{
				$this->addClass(trim($class));
			}
		
		}
		
		return $this;
	}
	
	
	protected function addClass($class)
	{
		if (!empty($class))
		{
			$this->classes[$class] = true;
		}
		
		return $this;
	}
	
	
	protected function remClass($class)
	{
		if (!empty($class))
		{
			unset($this->classes[$class]);
		}
		
		return $this;
	}
	
	
	public function tooltip($html)
	{
		return !empty($html) ? $this->addClass('hasTooltip')->setAttr('data-original-title', $html) : $this->remClass('hasTooltip')->remAttr('data-original-title');
	}
	
	
	public function required($value)
	{
		return $this->setBoolAttr('required', $value);
	}
	
	
	public function selected($value)
	{
		return $this->setBoolAttr('selected', $value);
	}
	
	
	public function checked($value)
	{
		return $this->setBoolAttr('checked', $value);
	}
	
	
	public function readonly($value)
	{
		return $this->setBoolAttr('readonly', $value);
	}
	
	
	public function show()
	{
		echo (string) $this;
	}
	
	
	public function render()
	{
		return (string) $this;
	}
	
	
	public function __toString()
	{
		return "<{$this->type}{$this->renderAttr()}>{$this->renderChildren()}</{$this->type}>";
	}
	
	
	protected function renderAttr()
	{
		$html = '';
		foreach ($this->attributes as $name => $value)
		{
			if ($name !== 'style' || !empty($value))
			{
				$html .= ' ' . $name . '="' . FoxHtmlEncoder::encode($value) . '"';
			}
		
		}
		
		if (count($this->classes) > 0)
		{
			$html .= ' class="' . FoxHtmlEncoder::encode(implode(' ', array_keys($this->classes))) . '"';
		}
		
		return $html;
	}
	
	
	protected function renderChildren()
	{
		$html = '';
		foreach ($this->children as $child)
		{
			$html .= $child;
		}
		
		return $html;
	}

}


class FoxHtmlTrasparentContainerElem extends FoxHtmlElem
{
	
	public function attr($name, $value = null)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function classes($classes)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function tooltip($html)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function required($value)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function selected($value)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function checked($value)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function readonly($value)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function __toString()
	{
		return $this->renderChildren();
	}

}


class FoxHtmlAutoCloseElem extends FoxHtmlElem
{
	
	public function conditional($condition, $generator)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function appends($sources, $generator)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function append($elem)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function text($text)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function html($html)
	{
		throw new Exception('Method [' . __METHOD__ . '] not supported for [' . __CLASS__ . '].');
	}
	
	
	public function __toString()
	{
		return "<{$this->type}{$this->renderAttr()}/>";
	}

}