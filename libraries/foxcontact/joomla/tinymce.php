<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxJoomlaTinyMCE
{
	private static $inited = false;
	private static $result = false;
	
	public static function init()
	{
		if (!self::$inited)
		{
			$document = JFactory::getDocument();
			if ($document instanceof JDocumentHTML && is_file(JPATH_PLUGINS . '/editors/tinymce/tinymce.php'))
			{
				require_once JPATH_PLUGINS . '/editors/tinymce/tinymce.php';
				$mce_editor = new plgEditortinymce(new JEditor('tinymce'), array('type' => 'editors', 'name' => 'tinymce', 'params' => '{"lang_mode":1,"valid_elements":"*[*]","relative_urls":0,"skin_admin":99}'));
				$document->addCustomTag($mce_editor->onInit());
				self::$result = true;
			}
			
			self::$inited = true;
		}
		
		return self::$result;
	}

}