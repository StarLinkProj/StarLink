<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.lang');

class FoxDiagnosticConflicting
{
	
	public static function check($uid)
	{
		$extensions = array(new FoxDiagnosticConflictingExtensionYouJoomlaTemplates());
		foreach ($extensions as $extension)
		{
			if ($extension->detect() && !$extension->patch())
			{
				FoxJoomlaLang::load(false, true);
				$message = JText::_('COM_FOXCONTACT_ERR_CONFLICTING_EXTENSION');
				$link = JText::_('COM_FOXCONTACT_READ_MORE');
				FoxFormModel::getFormByUid($uid)->getBoard()->add("<span>{$message}</span> <a href='{$extension->link()}'>{$link}</a>", FoxFormBoard::warning, true);
			}
		
		}
	
	}

}

interface FoxDiagnosticConflictingExtension
{
	
	public function detect();
	
	public function patch();
	
	public function link();
}

class FoxDiagnosticConflictingExtensionYouJoomlaTemplates implements FoxDiagnosticConflictingExtension
{
	
	public function detect()
	{
		return function_exists('yjsg_validate_data') && !defined('yjsg_validate_data_fixed');
	}
	
	
	public function patch()
	{
		$patch = '<?php defined("_JEXEC") or die(); define("yjsg_validate_data_fixed", 1); function yjsg_validate_data($array) {} ';
		$function = new ReflectionFunction('yjsg_validate_data');
		$filename = $function->getFileName();
		$result = file_put_contents($filename, $patch);
		return (bool) $result;
	}
	
	
	public function link()
	{
		return 'http://www.fox.ra.it/forum/24-troubleshooting/8760-youjoomla-template-removes-special-and-non-latin-characters.html';
	}

}