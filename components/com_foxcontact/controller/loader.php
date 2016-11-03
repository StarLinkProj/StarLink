<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.form.model');
jimport('foxcontact.html.header');

class FoxContactControllerLoader extends JControllerLegacy
{
	private static $mime_types = array('js' => 'Content-Type: application/javascript; charset=utf-8', 'css' => 'Content-Type: text/css; charset=utf-8');
	
	public function load()
	{
		$input = JFactory::getApplication()->input;
		$uid = $input->get('uid');
		$root = $input->get('root');
		$name = $input->get('name');
		$type = $input->get('type');
		$headers = FoxHtmlHeader::getUncachableHeader();
		if (isset(self::$mime_types[$type]))
		{
			$headers[] = self::$mime_types[$type];
		}
		
		FoxHtmlHeader::sendHeaders($headers);
		self::requireFile($uid, $root, $name, $type);
		JFactory::getApplication()->close();
	}
	
	
	private static function requireFile($uid, $root, $name, $type)
	{
		$juri_root = JUri::root(true);
		$form = FoxFormModel::getFormByUid($uid);
		ob_start(function ($text) use($uid, $juri_root, $form, $type)
		{
			$processor_name = "FoxContactControllerLoader{$type}PostProcessor";
			$processor = class_exists($processor_name) ? new $processor_name($uid, $juri_root, $form) : null;
			return !is_null($processor) ? $processor->process($text) : $text;
		});
		require_once self::getFilePath($root, $name, $type);
		ob_end_flush();
	}
	
	
	private static function getFilePath($root, $name, $type)
	{
		switch ($root)
		{
			case 'media':
				return JPATH_ROOT . "/media/com_foxcontact/{$type}/{$name}.{$type}";
			case 'components':
				return JPATH_ROOT . "/components/com_foxcontact/{$type}/{$name}.{$type}";
			default:
				throw new RuntimeException("Unknow root: '{$root}'.'");
		}
	
	}

}

interface FoxContactControllerLoaderPostProcessor
{
	
	public function process($text);
}

class FoxContactControllerLoaderCssPostProcessor implements FoxContactControllerLoaderPostProcessor
{
	private $uid;
	private $digitId;
	private $juri_root;
	private $form;
	private $submit;
	
	public function __construct($uid, $juri_root, $form)
	{
		$this->uid = $uid;
		$this->digitId = substr($uid, 1);
		$this->juri_root = $juri_root;
		$this->form = $form;
		$this->submit = $form->getDesign()->getFoxDesignItemByType('submit');
	}
	
	
	public function process($text)
	{
		return str_replace(array('div#fox-container-uid', 'foxDigitId', 'url("../../../', 'url(\'../../../', '/*$this->getFormWidth()*/ 0 /*;*/', '/*$this->getLabelWidth()*/ 0 /*;*/', '/*$this->getControlWidth()*/ 0 /*;*/', '/*$this->getCaptchaBackgroundColor()*/ #000000 /*;*/', '/*$this->getCaptchaImgWidth()*/ 0 /*;*/', '/*$this->getSubmitUrl(\'submit\')*/ url("") /*;*/', '/*$this->getSubmitUrl(\'submit\')*/ url(\'\') /*;*/', '/*$this->getSubmitImgWidth(\'submit\')*/ 0 /*;*/', '/*$this->getSubmitImgHeight(\'submit\')*/ 0 /*;*/', '/*$this->getSubmitUrl(\'reset\')*/ url("") /*;*/', '/*$this->getSubmitUrl(\'reset\')*/ url(\'\') /*;*/', '/*$this->getSubmitImgWidth(\'reset\')*/ 0 /*;*/', '/*$this->getSubmitImgHeight(\'reset\')*/ 0 /*;*/'), array("div#fox-container-{$this->uid}", $this->digitId, "url(\"{$this->juri_root}/", "url('{$this->juri_root}/", $this->getFormWidth(), $this->getLabelWidth(), $this->getControlWidth(), $this->getCaptchaBackgroundColor(), $this->getCaptchaImgWidth(), $this->getSubmitUrl('submit'), $this->getSubmitUrl('submit'), $this->getSubmitImgWidth('submit'), $this->getSubmitImgHeight('submit'), $this->getSubmitUrl('reset'), $this->getSubmitUrl('reset'), $this->getSubmitImgWidth('reset'), $this->getSubmitImgHeight('reset')), $text);
	}
	
	
	private function getFormWidth()
	{
		$width = $this->form->getDesign()->get('option.form.width');
		switch ($width->get('unit'))
		{
			case 'auto':
				return 'auto';
			default:
				return "{$width->get('value')}{$width->get('unit')}";
		}
	
	}
	
	
	private function getLabelWidth()
	{
		$width = $this->form->getDesign()->get('option.label.width');
		return "{$width->get('value')}{$width->get('unit')}";
	}
	
	
	private function getControlWidth()
	{
		$width = $this->form->getDesign()->get('option.control.width');
		return "{$width->get('value')}{$width->get('unit')}";
	}
	
	
	private function getCaptchaBackgroundColor()
	{
		$item = $this->form->getDesign()->getFoxDesignItemByType('captcha');
		return !is_null($item) ? $item->get('img.background_color') : '#000000';
	}
	
	
	private function getCaptchaImgWidth()
	{
		$item = $this->form->getDesign()->getFoxDesignItemByType('captcha');
		return !is_null($item) ? "{$item->get('img.width')}px" : '0';
	}
	
	
	private function getSubmitUrl($type)
	{
		return "url('{$this->submit->getImageUrl($type)}')";
	}
	
	
	private function getSubmitImgWidth($type)
	{
		return "{$this->submit->getImageWidth($type)}px";
	}
	
	
	private function getSubmitImgHeight($type)
	{
		return "{$this->submit->getImageHeight($type)}px";
	}

}