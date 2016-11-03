<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

abstract class FoxFieldWizard extends JFormField
{
	
	public static function setWizardValue($field)
	{
		$current_value = $field->value;
		if (empty($current_value))
		{
			if (!(bool) $field->form->getValue('id') || (bool) $field->form->getValue('toggle_modules'))
			{
				$field->value = self::resolve((string) $field->element['wizard']);
			}
		
		}
	
	}
	
	
	public static function setWizardPlaceholder($field)
	{
		$field->{'placeholder'} = self::resolve((string) $field->element['wizard_placeholder']);
	}
	
	
	public static function resolve($value)
	{
		switch ($value)
		{
			case 'user.email':
				$user = JFactory::getUser();
				return $user->email;
			case 'user.name':
				$user = JFactory::getUser();
				return $user->name;
			case 'user.id':
				$user = JFactory::getUser();
				return $user->id;
			case 'system.email':
				return JFactory::getConfig()->get('mailfrom', '');
			case 'system.email.if.neq.user.email':
				$mail_from = JFactory::getConfig()->get('mailfrom', '');
				$user = JFactory::getUser();
				return $user->email !== $mail_from ? $mail_from : '';
			case 'system.email_name':
				return JFactory::getConfig()->get('fromname', '');
			default:
				return JText::_($value);
		}
	
	}

}