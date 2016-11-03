<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

class FoxHtmlHeader
{
	
	public static function getCachableHeader()
	{
		$headers = array();
		$headers[] = 'Cache-Control: max-age=604800, public';
		$headers[] = 'Connection: keep-alive, Keep-Alive';
		$headers[] = 'Date: ' . gmdate('D, d M Y H:i:s') . ' GMT';
		$headers[] = 'Expires: ' . gmdate('D, d M Y H:i:s', time() + 604800) . ' GMT';
		return $headers;
	}
	
	
	public static function getUncachableHeader()
	{
		$headers = array();
		$headers[] = 'Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT';
		$headers[] = 'Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT';
		$headers[] = 'Cache-Control: no-cache, private, must-revalidate, max-age=0';
		$headers[] = 'Pragma: no-cache';
		return $headers;
	}
	
	
	public static function sendHeaders($headers)
	{
		foreach ($headers as $header)
		{
			header($header);
		}
	
	}

}