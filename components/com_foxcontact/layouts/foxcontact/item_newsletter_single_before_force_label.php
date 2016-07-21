<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
list($uid, $board, $current, $form) = FoxFormRender::listFormVariables('uid,board');
$newsletters = $current->getNewsletters();
if (!is_null($newsletters))
{
	FoxHtmlElem::create('div')->attr('id', $current->getBoxId())->classes('fox-item fox-item-checkbox control-group')->classes($current->get('classes'))->append(FoxFormRender::render('label_beside'))->append(FoxHtmlElem::create('div')->classes('controls')->attr('style', "{$current->getStyleWidth()}{$current->getStyleHeight()}")->append(FoxHtmlElem::create('input')->attr('id', $current->getItemId())->attr('name', $current->getInputName())->attr('type', 'checkbox')->attr('value', JText::_('JYES'))->checked($current->getInputValue() === JText::_('JYES'))))->show();
}