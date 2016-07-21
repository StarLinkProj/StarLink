<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
list($uid, $board, $current, $form) = FoxFormRender::listFormVariables('uid,board');
FoxHtmlElem::create('div')->attr('id', $current->getBoxId())->classes('fox-item fox-item-radio control-group')->classes($current->get('classes'))->classes($board->getItemDecorationClass($current->get('unique_id')))->append(FoxFormRender::render('label'))->append(FoxHtmlElem::create('div')->classes('controls')->append(FoxHtmlElem::create('div')->attr('id', $current->getItemId())->attr('style', "{$current->getStyleWidth()}{$current->getStyleHeight()}")->append(FoxFormRender::render('label_inside_no_placeholder'))->appends($current->get('options'), function ($source) use($current, $form, $board)
{
	return FoxHtmlElem::create()->append(FoxHtmlElem::create('label')->append(FoxHtmlElem::create('input')->attr('type', 'radio')->attr('name', $current->getInputName())->checked($source->get('text') === $current->getInputValue())->attr('value', $source->get('text')))->append(FoxHtmlElem::create()->text($source->get('text')))->conditional($board->isValidated() && $board->isFieldInvalid($current->get('unique_id')), function ()
	{
		return FoxHtmlElem::create('span')->classes('asterisk');
	}))->conditional($form->getDesign()->get('option.form.render') === 'stacked', function ()
	{
		return FoxHtmlElem::create('br');
	});
})))->show();