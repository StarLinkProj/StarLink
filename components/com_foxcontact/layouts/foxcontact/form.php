<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
list($uid, $board, $current, $form) = FoxFormRender::listFormVariables('uid,board');
FoxHtmlElem::create()->append(FoxHtmlElem::create('div')->attr('id', "fox-container-{$uid}")->classes('fox-container')->classes("fox-container-{$form->getScope()}")->classes($form->getParams()->get('pageclass_sfx'))->classes($form->getParams()->get('moduleclass_sfx'))->conditional($form->getParams()->get('show_page_heading', JComponentHelper::getParams('com_menus')->get('show_page_heading')), function () use($form)
{
	return FoxHtmlElem::create('h1')->text($form->getParams()->get('page_heading'));
})->append(FoxHtmlElem::create('a')->attr('id', "fox_{$uid}"))->conditional(!$board->getShowFormFields(), function ()
{
	return FoxFormRender::render('form_board');
})->conditional($board->getShowFormFields(), function () use($uid, $form)
{
	return FoxHtmlElem::create('form')->attr('name', "fox-form-{$uid}")->attr('action', JRoute::_('index.php'))->attr('method', 'post')->attr('enctype', 'multipart/form-data')->classes("fox-form fox-form-{$form->getDesign()->get('option.form.render')}")->append("<!-- Fox Contact [scope:{$form->getScope()}] [id:{$form->getId()}] [ver:{$form->getVersion()}] -->")->append(FoxFormRender::renders('row', $form->getDesign()->get('rows')))->append(FoxHtmlElem::create('input')->attr('type', 'hidden')->attr('name', 'option')->attr('value', 'com_foxcontact'))->append(FoxHtmlElem::create('input')->attr('type', 'hidden')->attr('name', 'task')->attr('value', 'form.send'))->append(FoxHtmlElem::create('input')->attr('type', 'hidden')->attr('name', 'uid')->attr('value', $uid))->append(FoxHtmlElem::create('input')->attr('type', 'hidden')->attr('name', 'fox_form_page_uri')->attr('value', JUri::getInstance()))->append(FoxHtmlElem::create('input')->attr('type', 'hidden')->attr('name', 'fox_form_page_title')->attr('value', JFactory::getDocument()->getTitle()));
}))->show();