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
 * Class HikashopPagetype
 * @package RegularLabs\Library\Condition
 */
class HikashopPagetype
	extends Hikashop
	implements \RegularLabs\Library\Api\ConditionInterface
{
	public function pass()
	{
		if ($this->request->option != 'com_hikashop')
		{
			return $this->_(false);
		}

		$type = $this->request->view;
		if (
			($type == 'product' && in_array($this->request->layout, ['contact', 'show']))
			|| ($type == 'user' && in_array($this->request->layout, ['cpanel']))
		)
		{
			$type .= '_' . $this->request->layout;
		}

		return $this->passSimple($type);
	}
}
