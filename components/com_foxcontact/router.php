<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
function getFoxContactParameters()
{
	static $result = array(0 => 'view', 1 => 'owner', 2 => 'id', 3 => 'root', 4 => 'filename', 5 => 'type');
	return $result;
}
function FoxContactBuildRoute(&$query)
{
	$segments = array();
	$parameters = getFoxContactParameters();
	foreach ($parameters as $name)
	{
		if (isset($query[$name]))
		{
			$segments[] = $query[$name];
			unset($query[$name]);
		}
		else
		{
			break;
		}
	
	}
	
	return $segments;
}
function FoxContactParseRoute($segments)
{
	$vars = array();
	$parameters = getFoxContactParameters();
	foreach ($parameters as $index => $name)
	{
		if (isset($segments[$index]))
		{
			$vars[$name] = preg_replace('/[^A-Z0-9_]/i', '', $segments[$index]);
		}
		else
		{
			break;
		}
	
	}
	
	return $vars;
}