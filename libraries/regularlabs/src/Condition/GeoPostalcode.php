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

/**
 * Class GeoPostalcode
 * @package RegularLabs\Library\Condition
 */
class GeoPostalcode
	extends Geo
	implements \RegularLabs\Library\Api\ConditionInterface
{
	public function pass()
	{
		if (!$this->getGeo() || empty($this->geo->postalCode))
		{
			return $this->_(false);
		}

		// replace dashes with dots: 730-0011 => 730.0011
		$postalcode = str_replace('-', '.', $this->geo->postalCode);

		return $this->passInRange($postalcode);
	}
}
