<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.joomla.lang');
list($uid, $board, $current, $form) = FoxFormRender::listFormVariables('uid,board');
FoxJoomlaLang::load(false, true);
FoxHtmlElem::create('div')->attr('id', $current->getBoxId())->classes('fox-item fox-item-captcha fox-item-captcha-disabled control-group')->classes($current->get('classes'))->append(FoxFormRender::render('label'))->append(FoxHtmlElem::create('div')->classes('controls')->append(FoxHtmlElem::create('span')->classes('alert alert-error')->text(JText::_('COM_FOXCONTACT_FUNCTION_RECAPTCHA_DISABLED'))))->show();