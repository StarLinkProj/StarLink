<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
jimport('joomla.filesystem.folder');
jimport('foxcontact.html.encoder');

abstract class FoxHtmlCaptchaDrawer
{
	protected $charset;
	protected $question;
	protected $answer;
	protected $length;
	protected $font_min, $font_max, $font_angle, $font_family;
	protected $image_width, $image_height, $image_data, $colors_background, $colors_text, $colors_disturb;
	
	public static function create($type)
	{
		switch ($type)
		{
			case 'mathematical':
				return new FoxHtmlMathCaptchaDrawer();
			case 'alphanumeric':
				return new FoxHtmlStandardCaptchaDrawer();
			default:
				return new FoxHtmlStandardCaptchaDrawer();
		}
	
	}
	
	
	public function setLength($length = 5)
	{
		$this->length = (int) $length;
	}
	
	
	public function setFontProperty($min = 14, $max = 20, $angle = 20, $family = 'random')
	{
		$this->font_min = (int) $min;
		$this->font_max = (int) $max;
		$this->font_angle = (int) $angle;
		$fontdir = JPATH_SITE . '/media/com_foxcontact/fonts/';
		if ($family === 'random')
		{
			$fonts = JFolder::files($fontdir, '\\.ttf$');
			$family = $fonts[rand(0, count($fonts) - 1)];
		}
		
		$this->font_family = $fontdir . $family;
	}
	
	
	public function setImageProperty($width = 270, $height = 100, $background_color = '#ffffff', $text_color = '#191919', $disturb_color = '#c8c8c8')
	{
		$this->image_width = (int) $width;
		$this->image_height = (int) $height;
		if (!is_null($this->image_data))
		{
			imagedestroy($this->image_data);
		}
		
		$this->image_data = imagecreate($this->image_width, $this->image_height);
		$background = $this->parseColor($background_color, '#ffffff');
		$this->colors_background = imagecolorallocate($this->image_data, $background[0], $background[1], $background[2]);
		$text = $this->parseColor($text_color, '#191919');
		$this->colors_text = imagecolorallocate($this->image_data, $text[0], $text[1], $text[2]);
		$disturb = $this->parseColor($disturb_color, '#c8c8c8');
		$this->colors_disturb = imagecolorallocate($this->image_data, $disturb[0], $disturb[1], $disturb[2]);
	}
	
	
	private function parseColor($color, $default)
	{
		return $this->isValidHexColor($color) ? sscanf($color, '#%2x%2x%2x') : sscanf($default, '#%2x%2x%2x');
	}
	
	
	private function isValidHexColor($color)
	{
		return strlen($color) == 7 && preg_match('/#[0-9a-fA-F]{6}/', $color) == 1;
	}
	
	
	public abstract function shuffle();
	
	public function draw()
	{
		imagefill($this->image_data, 0, 0, $this->colors_background);
		$this->drawBackground();
		$len = strlen($this->question);
		$space = $this->image_width / $len;
		for ($p = 0; $p < 2 * $len; ++$p)
		{
			$this->render(chr(rand(33, 126)), $p, $space / 2, $this->colors_disturb);
		}
		
		for ($p = 0; $p < $len; ++$p)
		{
			$this->render($this->question[$p], $p, $space, $this->colors_text);
		}
		
		imagejpeg($this->image_data);
		imagedestroy($this->image_data);
	}
	
	
	protected abstract function drawBackground();
	
	private function render($character, $position, $space, $color)
	{
		imagettftext($this->image_data, rand($this->font_min, $this->font_max), rand(-$this->font_angle, $this->font_angle), rand($position * $space + $this->font_min, ($position + 1) * $space - $this->font_max), rand($this->font_max, $this->image_height - $this->font_max), $color, $this->font_family, $character);
	}

}


class FoxHtmlMathCaptchaDrawer extends FoxHtmlCaptchaDrawer
{
	
	public function __construct()
	{
		$this->charset = '+-*';
	}
	
	
	public function shuffle()
	{
		$this->question = rand(6, 11) . substr(str_shuffle($this->charset), 0, 1) . rand(1, 5);
		eval("\$this->answer = strval({$this->question});");
		return $this->answer;
	}
	
	
	protected function drawBackground()
	{
		$grid_size = intval(($this->font_min + $this->font_max) / 2);
		for ($x = $grid_size; $x < $this->image_width; $x += $grid_size)
		{
			imageline($this->image_data, $x, 0, $x, $this->image_height, $this->colors_disturb);
		}
		
		for ($y = $grid_size; $y < $this->image_height; $y += $grid_size)
		{
			imageline($this->image_data, 0, $y, $this->image_width, $y, $this->colors_disturb);
		}
	
	}

}


class FoxHtmlStandardCaptchaDrawer extends FoxHtmlCaptchaDrawer
{
	
	public function __construct()
	{
		$this->charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
	}
	
	
	public function shuffle()
	{
		$this->question = $this->answer = substr(str_shuffle($this->charset), 0, $this->length);
		return $this->answer;
	}
	
	
	protected function drawBackground()
	{
	}

}