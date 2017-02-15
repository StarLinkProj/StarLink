<?php
/**
 * @package         Regular Labs Library
 * @version         17.2.10818
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Library\Condition;

defined('_JEXEC') or die;

use PlgSystemCookieconfirmCore;

/**
 * Class Cookieconfirm
 * @package RegularLabs\Library\Condition
 */
class Cookieconfirm
	extends \RegularLabs\Library\Condition
	implements \RegularLabs\Library\Api\ConditionInterface
{
	public function pass()
	{
		require_once JPATH_PLUGINS . '/system/cookieconfirm/core.php';
		$pass = PlgSystemCookieconfirmCore::getInstance()->isCookiesAllowed();

		return $this->_($pass);
	}
}
