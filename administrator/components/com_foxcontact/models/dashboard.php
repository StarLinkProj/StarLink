<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxContactModelDashboard extends JModelLegacy
{
	
	public function getExtensionId()
	{
		return $this->_db->setQuery($this->_db->getQuery(true)->select('extension_id')->from('#__extensions')->where('element = \'mod_foxcontact\'')->where('client_id = 0'))->loadResult();
	}

}