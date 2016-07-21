<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
list($uid, $board, $current, $form) = FoxFormRender::listFormVariables('uid,board');
FoxHtmlElem::create()->conditional($form->getDesign()->get('option.label.position') === 'inside' && !$current->isEmpty('label'), function () use($current)
{
	return FoxHtmlElem::create('span')->classes('fox-label-inside-no-placeholder')->text($current->get('label'))->tooltip($current->get('tooltip'))->conditional($current->get('required'), function ()
	{
		return FoxHtmlElem::create('span')->classes('required');
	});
})->show();