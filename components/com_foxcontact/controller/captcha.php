<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('foxcontact.form.model');
jimport('foxcontact.html.header');
jimport('foxcontact.html.captcha');
jimport('foxcontact.joomla.comp');

class FoxContactControllerCaptcha extends JControllerLegacy
{
	
	public function generate()
	{
		$input = JFactory::getApplication()->input;
		$uid = $input->get('uid', '-');
		$item = $uid !== '-' ? FoxFormModel::getFormByUid($uid)->getDesign()->getFoxDesignItemByType('captcha') : null;
		$params = !is_null($item) ? $item : FoxJoomlaComp::newJRegistry($_GET);
		$drawer = FoxHtmlCaptchaDrawer::create($params->get('enigma.type', 'alphanumeric'));
		$drawer->setLength($params->get('enigma.length', 5));
		$drawer->setFontProperty($params->get('font.min', 14), $params->get('font.max', 20), $params->get('font.angle', 20), $params->get('font.family', 'random'));
		$drawer->setImageProperty($params->get('img.width', 270), $params->get('img.height', 100), $params->get('img.background_color', '#ffffff'), $params->get('img.text_color', '#191919'), $params->get('img.disturb_color', '#c8c8c8'));
		$answer = $drawer->shuffle();
		if (!is_null($item))
		{
			$item->setAnswer($answer);
		}
		
		$headers = FoxHtmlHeader::getUncachableHeader();
		$headers[] = 'Content-Type: image/jpeg';
		$headers[] = 'Content-Disposition: inline; filename="foxcaptcha.jpg"';
		FoxHtmlHeader::sendHeaders($headers);
		$drawer->draw();
		JFactory::getApplication()->close();
	}

}