<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
list($uid, $board, $current, $form) = FoxFormRender::listFormVariables('uid,board');
FoxHtmlElem::create('div')->attr('id', $current->getBoxId())->classes("fox-item fox-item-submit fox-item-submit-{$current->get('alignment')} control-group")->classes($current->get('classes'))->append(FoxFormRender::render('label_collapsed'))->append(FoxHtmlElem::create('div')->classes('controls')->attr('style', "{$current->getStyleWidth()}{$current->getStyleHeight()}")->append(FoxHtmlElem::create('button')->classes('btn btn-success submit-button')->tooltip($current->get('submit.tooltip'))->attr('type', 'submit')->append(FoxHtmlElem::create('span')->append(FoxHtmlElem::create('span')->classes($current->getIconClass('submit'))->attr('style', $current->getIconStyle('submit'))->text($current->get('submit.label')))))->conditional($current->get('reset.enable'), function () use($current)
{
	return FoxHtmlElem::create('button')->classes('btn btn-danger reset-button')->tooltip($current->get('reset.tooltip'))->attr('type', 'reset')->append(FoxHtmlElem::create('span')->append(FoxHtmlElem::create('span')->classes($current->getIconClass('reset'))->attr('style', $current->getIconStyle('reset'))->text($current->get('reset.label'))));
}))->show();