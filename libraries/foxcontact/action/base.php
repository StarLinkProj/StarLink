<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

abstract class FoxActionBase
{
	protected $form, $params;
	
	public function __construct($form)
	{
		JLog::addLogger(array('text_file' => 'foxcontact.php', 'text_entry_format' => "{DATE}\t{TIME}\t{PRIORITY}\t{CATEGORY}\t{MESSAGE}"), JLog::ALL, array('action'));
		$this->form = $form;
		$this->params = $form->getParams();
	}
	
	
	public abstract function process($target);
}