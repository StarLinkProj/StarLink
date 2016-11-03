<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('joomla.filesystem.folder');
jimport('foxcontact.html.elem');
jimport('foxcontact.form.newsletter');
jimport('foxcontact.struct.manager');
jimport('foxcontact.html.resource');
jimport('foxcontact.joomla.tinymce');
jimport('foxcontact.joomla.lang');

class JFormFieldVisualDesigner extends JFormField
{
	protected $type = 'VisualDesigner';
	
	public function __construct($form = null)
	{
		parent::__construct($form);
		JLog::addLogger(array('text_file' => 'foxcontact.lng_js.txt', 'text_entry_format' => "{DATE}\t{TIME}\t{PRIORITY}\t{CATEGORY}\t{MESSAGE}"), JLog::ALL, array('lng_js'));
	}
	
	
	protected function getLabel()
	{
		return '';
	}
	
	
	protected function getInput()
	{
		if (JFactory::getApplication()->input->get('option', '') === 'com_falang')
		{
			$this->warnUserEditFromFalang();
			return '';
		}
		
		if (empty($this->value) || $this->value === '{}')
		{
			$this->value = $this->getDefaultValue((string) $this->element['default-scope']);
		}
		
		$this->value = json_encode(FoxStructManager::check($this->value));
		$this->addFolderFiles('js/designer', 'js', 'addScript');
		$this->addFolderFiles('css/designer', 'css', 'addStyleSheet');
		FoxJoomlaTinyMCE::init();
		JHtml::_('jquery.ui', array('core', 'sortable'));
		$media_root = JPATH_ROOT . '/media/com_foxcontact';
		$cmp_root = JPATH_ROOT . '/components/com_foxcontact';
		$ln = JFactory::getLanguage()->getTag();
		$lng_file_ver = $this->verifyLngJsFile($ln);
		JFactory::getDocument()->addScript(JUri::base(true) . "/cache/foxcontact/{$ln}.foxcontact.js?v={$lng_file_ver}")->addScriptDeclaration(";\n;fox.items.captcha.files=" . json_encode(JFolder::files("{$media_root}/fonts", '\\.ttf$')) . ";\n" . ";\n;fox.gesture_click_frm_edt.styles=" . json_encode(JFolder::files("{$cmp_root}/css", '\\.css$')) . ";\n" . ";\n;fox.items.submit.files=" . json_encode(array('submit' => array('icons' => JFolder::files("{$media_root}/images/submit", '\\.png$'), 'images' => JFolder::files("{$media_root}/images/buttons/submit", '\\.png$')), 'reset' => array('icons' => JFolder::files("{$media_root}/images/reset", '\\.png$'), 'images' => JFolder::files("{$media_root}/images/buttons/reset", '\\.png$')))) . ";\n" . ";\n;fox.items.newsletter.newsletters=" . json_encode(array_filter(array(FoxFormNewsletter::load('acymailing'), FoxFormNewsletter::load('jnews')))) . ";\n");
		return FoxHtmlElem::create()->append(FoxHtmlElem::create('input')->attr('id', $this->id)->attr('name', $this->name)->attr('type', 'hidden')->attr('value', $this->value))->append(FoxHtmlElem::create('div')->attr('id', 'fvd-target-1')->classes('fvd-target')->attr('style', 'display: none;'))->append(FoxHtmlElem::create('div')->attr('id', 'fvd-target-2')->classes('fvd-target')->attr('style', 'display: none;'))->append(FoxHtmlElem::create('div')->attr('id', 'fvd-window-1')->classes('fvd-window')->attr('style', 'display: none;'))->append(FoxHtmlElem::create('div')->attr('id', 'fvd-designer')->classes('fvd-visual-designer')->attr('data-ref', $this->id))->conditional(JDEBUG, function ()
		{
			return FoxHtmlElem::create('pre')->attr('id', 'fvd-debug')->classes('fvd-debug')->attr('style', 'display: none;');
		})->render();
	}
	
	
	private function warnUserEditFromFalang()
	{
		JEventDispatcher::getInstance()->register('onAfterDispatch', function ()
		{
			FoxJoomlaLang::load(true, true);
			$ttl = JText::_('WARNING');
			$lnk = JText::_('COM_FOXCONTACT_READ_MORE');
			$msg = JText::_('COM_FOXCONTACT_ERR_COM_FALANG');
			$url = 'http://www.fox.ra.it/forum/22-how-to/5042-setup-a-multilanguage-form.html';
			JFactory::getDocument()->setBuffer("<div class='alert'><strong>{$ttl}</strong><br><span>{$msg}</span> <a href='{$url}'>{$lnk}</a></div>", 'component');
		});
		JEventDispatcher::getInstance()->register('onRenderModule', function ($module)
		{
			if ($module->module === 'mod_toolbar')
			{
				$toolbar = JToolbar::getInstance('com_foxcontact_edit_outside_toolbar');
				$toolbar->appendButton('Link', 'back', JText::_('JTOOLBAR_BACK'), JRoute::_('index.php?option=com_falang&task=translate.overview'));
				$module->content = $toolbar->render();
			}
		
		});
	}
	
	
	private function verifyLngJsFile($ln)
	{
		$cache_directory = JPATH_ADMINISTRATOR . '/cache/foxcontact';
		@mkdir($cache_directory, 511, true);
		if (!is_dir($cache_directory))
		{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_FOXCONTACT_CACHE_WRITE_ERROR'), 'error');
			JLog::add('Error creating the cache directory.', JLog::ERROR, 'lng_js');
			return '';
		}
		
		if (!is_file($htaccess = $cache_directory . '/.htaccess'))
		{
			@file_put_contents($htaccess, "<IfModule mod_rewrite.c>\nRewriteEngine Off\n</IfModule>");
		}
		
		$cache_file = $cache_directory . "/{$ln}.foxcontact.js";
		if ($this->isExpiredLngJsFile($cache_file, $ln))
		{
			$this->buildLngJsFile($cache_file);
		}
		
		return @filemtime($cache_file);
	}
	
	
	private function isExpiredLngJsFile($file_name, $ln)
	{
		$files = array(JPATH_ADMINISTRATOR . '/components/com_foxcontact/language/en-GB/en-GB.com_foxcontact.ini', JPATH_ADMINISTRATOR . "/components/com_foxcontact/language/{$ln}/{$ln}.com_foxcontact.ini", JPATH_ADMINISTRATOR . '/language/overrides/en-GB.override.ini', JPATH_ADMINISTRATOR . "/language/overrides/{$ln}.override.ini", JPATH_ROOT . '/components/com_foxcontact/language/en-GB/en-GB.com_foxcontact.ini', JPATH_ROOT . "/components/com_foxcontact/language/{$ln}/{$ln}.com_foxcontact.ini", JPATH_ROOT . '/language/overrides/en-GB.override.ini', JPATH_ROOT . "/language/overrides/{$ln}.override.ini");
		$reference = @filemtime($file_name) or $reference = 0;
		foreach ($files as $file)
		{
			if (@filemtime($file) > $reference)
			{
				return true;
			}
		
		}
		
		return false;
	}
	
	
	private function buildLngJsFile($file_name)
	{
		$path_info = pathinfo($file_name);
		JLog::add("Start generating the cache file [{$path_info['basename']}].", JLog::INFO, 'lng_js');
		$result = array();
		FoxJoomlaLang::load(true, true);
		$untranslated_strings = 0;
		foreach ($this->getLngJsFileKeys() as $k)
		{
			$result[$k] = JText::_($k);
			if (strtoupper($k) === strtoupper($result[$k]))
			{
				$untranslated_strings += 1;
			}
		
		}
		
		if ($untranslated_strings > 0)
		{
			JLog::add("Error translating keys for the cache file [{$path_info['basename']}] untranslated strings: {$untranslated_strings}.", JLog::ERROR, 'lng_js');
			JLog::add("print_r(JFactory::getLanguage())\n" . print_r(JFactory::getLanguage(), true), JLog::ERROR, 'lng_js');
		}
		
		$result = json_encode($result);
		$bytes = file_put_contents($file_name, "fox.lang.init({$result});");
		if ($bytes === false)
		{
			JLog::add("Error writing the cache file [{$path_info['basename']}].", JLog::ERROR, 'lng_js');
			JFactory::getApplication()->enqueueMessage(JText::_('COM_FOXCONTACT_CACHE_WRITE_ERROR'), 'error');
		}
		else
		{
			if ($untranslated_strings > 0)
			{
			}
			
			JLog::add("Generated the cache file [{$path_info['basename']}].", JLog::INFO, 'lng_js');
		}
	
	}
	
	
	private function getLngJsFileKeys()
	{
		return array_merge($this->getLngKeysFromIniFile('/administrator/components/com_foxcontact/language/en-GB/en-GB.com_foxcontact.ini'), $this->getLngKeysFromIniFile('/components/com_foxcontact/language/en-GB/en-GB.com_foxcontact.ini'));
	}
	
	
	private function getLngKeysFromIniFile($file_name)
	{
		$content = @file_get_contents(JPATH_ROOT . $file_name);
		$array = @parse_ini_string($content);
		$keys = is_array($array) ? array_keys($array) : array();
		if (empty($keys))
		{
			JLog::add("Failed to load ini keys from [{$file_name}]", JLog::ERROR, 'lng_js');
		}
		
		return $keys;
	}
	
	
	private function addFolderFiles($folder, $type, $method)
	{
		$folder = "/components/com_foxcontact/{$folder}";
		$root_url = JUri::base(true);
		$document = JFactory::getDocument();
		$folder .= JDEBUG && file_exists(JPATH_BASE . $folder) ? '' : '.min';
		$files = glob(JPATH_BASE . "{$folder}/*.{$type}") or $files = array();
		foreach ($files as $file)
		{
			$document->{$method}($root_url . $folder . '/' . pathinfo($file, PATHINFO_BASENAME));
		}
	
	}
	
	
	private function getDefaultValue($scope)
	{
		switch (strtolower($scope))
		{
			case 'component':
				return require __DIR__ . '/design.component.php';
			case 'module':
				return require __DIR__ . '/design.module.php';
			default:
				return require __DIR__ . '/design.naked.php';
		}
	
	}

}