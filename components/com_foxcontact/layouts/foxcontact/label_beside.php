<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
list($uid, $board, $current, $form) = FoxFormRender::listFormVariables('uid,board');
FoxHtmlElem::create()->conditional(!$current->isEmpty('label'), function () use($current)
{
	return FoxHtmlElem::create('div')->classes('control-label')->append(FoxHtmlElem::create()->conditional(strlen($current->getLabelForId()) === 0, function () use($current)
	{
		return FoxHtmlElem::create('span')->tooltip($current->get('tooltip'))->html($current->get('label'))->conditional($current->get('required'), function ()
		{
			return FoxHtmlElem::create('span')->classes('required');
		});
	})->conditional(strlen($current->getLabelForId()) > 0, function () use($current)
	{
		return FoxHtmlElem::create('label')->attr('for', $current->getLabelForId())->tooltip($current->get('tooltip'))->html($current->get('label'))->conditional($current->get('required'), function ()
		{
			return FoxHtmlElem::create('span')->classes('required');
		});
	}));
})->conditional($current->isEmpty('label'), function () use($current)
{
	return FoxFormRender::render('label_collapsed');
})->show();