<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.html.resource');
jimport('foxcontact.design.item_options');

class FoxDesignItemDropdown extends FoxDesignItemOptions
{
	
	public function addResources($document)
	{
		$uncompressed = JDEBUG ? '-uncompressed' : '';
		$min = JDEBUG ? '' : '.min';
		$document->addScript(JUri::root(true) . '/media/system/js/core' . $uncompressed . '.js');
		$document->addScript(JUri::root(true) . '/media/jui/js/chosen.jquery' . $min . '.js');
		$document->addStyleSheet(JUri::root(true) . '/media/jui/css/chosen.css');
		$document->addScript(FoxHtmlResource::path('/media/com_foxcontact/js/chosen', 'js'));
	}

}