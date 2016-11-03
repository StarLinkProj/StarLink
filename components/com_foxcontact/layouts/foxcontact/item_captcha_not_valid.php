<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
list($uid, $board, $current, $form) = FoxFormRender::listFormVariables('uid,board');
FoxHtmlElem::create('div')->attr('id', $current->getBoxId())->classes('fox-item fox-item-captcha control-group')->classes($current->get('classes'))->classes($board->getItemDecorationClass($current->get('unique_id')))->append(FoxFormRender::render('label'))->append(FoxHtmlElem::create('div')->classes('controls')->attr('style', "{$current->getStyleWidth()}{$current->getStyleHeight()}")->append(FoxHtmlElem::create('div')->classes('fox-item-captcha-cnt')->append(FoxHtmlElem::create('img')->attr('id', $current->getItemId())->classes('fox-item-captcha-img')->attr('src', JRoute::_("index.php?option=com_foxcontact&task=captcha.generate&uid={$uid}&uniqueid=00000000", false))->attr('alt', 'captcha')->attr('width', $current->get('img.width'))->attr('height', $current->get('img.height')))->append(FoxHtmlElem::create('div')->append(FoxHtmlElem::create('div')->append(FoxHtmlElem::create('input')->attr('id', $current->getLabelForId())->attr('name', $current->getInputName())->attr('type', 'text')->attr('placeholder', $current->getPlaceholder()))->append(FoxHtmlElem::create('img')->classes('fox-item-captcha-img-reload')->attr('src', JUri::base(true) . '/media/com_foxcontact/images/reload-16.png')->attr('alt', JText::_('COM_FOXCONTACT_RELOAD_ALT'))->tooltip(JText::_('COM_FOXCONTACT_RELOAD_TITLE'))->attr('width', '16')->attr('height', '16')->attr('style', 'display: none;')->attr('data-captcha-img', $current->getItemId())))->conditional($board->isValidated() && $board->isFieldInvalid($current->get('unique_id')), function ()
{
	return FoxHtmlElem::create('span')->classes('asterisk');
}))))->show();