<?php
/**
 * @package         Advanced Module Manager
 * @version         7.1.0
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\AdvancedModules;

defined('_JEXEC') or die;

use RegularLabs\Library\Document as RL_Document;

class Helper
{
	public function onAfterInitialise()
	{
		if (Params::get()->initialise_event == 'onAfterRoute')
		{
			return;
		}

		$this->initialise();
	}

	public function onAfterRoute()
	{
		if (Params::get()->initialise_event != 'onAfterRoute')
		{
			return;
		}

		$this->initialise();
	}

	public function initialise()
	{
		if (RL_Document::isAdmin())
		{
			return;
		}

		ModuleHelper::load();
		ModuleHelper::registerEvents();
		Document::loadFrontEditScript();
	}

	public function onAfterRender()
	{
		Document::replaceLinks();
	}
}
