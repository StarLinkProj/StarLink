<?php defined('_JEXEC') or die(file_get_contents('index.html'));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 * Contributions by Ankur Shah
 */

class FoxHtmlUserAgentParser
{
	private $aryMaps = array('browser' => array('oldsafari' => array('version' => array('1.0' => '/8', '1.2' => '/1', '1.3' => '/3', '2.0' => '/412', '2.0.2' => '/416', '2.0.3' => '/417', '2.0.4' => '/419', '?' => '/'))), 'device' => array('amazon' => array('model' => array('Fire Phone' => array('SD', 'KF'))), 'sprint' => array('model' => array('Evo Shift 4G' => '7373KT'), 'vendor' => array('HTC' => 'APA', 'Sprint' => 'Sprint'))), 'os' => array('windows' => array('version' => array('ME' => '4.90', 'NT 3.11' => 'NT3.51', 'NT 4.0' => 'NT4.0', '2000' => 'NT 5.0', 'XP' => array('NT 5.1', 'NT 5.2'), 'Vista' => 'NT 6.0', '7' => 'NT 6.1', '8' => 'NT 6.2', '8.1' => 'NT 6.3', '10' => array('NT 6.4', 'NT 10.0'), 'RT' => 'ARM'))));
	private $aryRegexes = array();
	private $aryBrowserProp = array('NAME' => '-', 'VERSION' => '-');
	private $aryOS_Prop = array('NAME' => '-', 'VERSION' => '-');
	private $aryDeviceProp = array('MODEL' => '-', 'VENDOR' => '-', 'TYPE' => '-');
	private $strUserAgent;
	
	public function __construct($strOperateUA = '')
	{
		$this->aryRegexes = array('browser' => array(array('/(opera\\smini)\\/([\\w\\.-]+)/i', '/(opera\\s[mobiletab]+).+version\\/([\\w\\.-]+)/i', '/(opera).+version\\/([\\w\\.]+)/i', '/(opera)[\\/\\s]+([\\w\\.]+)/i'), array('NAME', 'VERSION'), array('/\\s(opr)\\/([\\w\\.]+)/i'), array(array('NAME', 'Opera'), 'VERSION'), array('/(kindle)\\/([\\w\\.]+)/i', '/(lunascape|maxthon|netfront|jasmine|blazer)[\\/\\s]?([\\w\\.]+)*/i', '/(avant\\s|iemobile|slim|baidu)(?:browser)?[\\/\\s]?([\\w\\.]*)/i', '/(?:ms|\\()(ie)\\s([\\w\\.]+)/i', '/(rekonq)\\/([\\w\\.]+)*/i', '/(chromium|flock|rockmelt|midori|epiphany|silk|skyfire|ovibrowser|bolt|iron|vivaldi)\\/([\\w\\.-]+)/i'), array('NAME', 'VERSION'), array('/(trident).+rv[:\\s]([\\w\\.]+).+like\\sgecko/i', '/(Edge)\\/((\\d+)?[\\w\\.]+)/i'), array(array('NAME', 'IE'), 'VERSION'), array('/(yabrowser)\\/([\\w\\.]+)/i'), array(array('NAME', 'Yandex'), 'VERSION'), array('/(comodo_dragon)\\/([\\w\\.]+)/i'), array(array('NAME', '/_/i', ' '), 'VERSION'), array('/(chrome|omniweb|arora|[tizenoka]{5}\\s?browser)\\/v?([\\w\\.]+)/i', '/(uc\\s?browser|qqbrowser)[\\/\\s]?([\\w\\.]+)/i'), array('NAME', 'VERSION'), array('/(dolfin)\\/([\\w\\.]+)/i'), array(array('NAME', 'Dolphin'), 'VERSION'), array('/((?:android.+)crmo|crios)\\/([\\w\\.]+)/i'), array(array('NAME', 'Chrome'), 'VERSION'), array('/XiaoMi\\/MiuiBrowser\\/([\\w\\.]+)/i'), array('VERSION', array('NAME', 'MIUI Browser')), array('/android.+version\\/([\\w\\.]+)\\s+(?:mobile\\s?safari|safari)/i'), array('VERSION', array('NAME', 'Android Browser')), array('/FBAV\\/([\\w\\.]+);/i'), array('VERSION', array('NAME', 'Facebook')), array('/version\\/([\\w\\.]+).+?mobile\\/\\w+\\s(safari)/i'), array('VERSION', array('NAME', 'Mobile Safari')), array('/version\\/([\\w\\.]+).+?(mobile\\s?safari|safari)/i'), array('VERSION', 'NAME'), array('/webkit.+?(mobile\\s?safari|safari)(\\/[\\w\\.]+)/i'), array('NAME', array('VERSION', 'mapper_str', $this->aryMaps['browser']['oldsafari']['version'])), array('/(konqueror)\\/([\\w\\.]+)/i', '/(webkit|khtml)\\/([\\w\\.]+)/i'), array('NAME', 'VERSION'), array('/(navigator|netscape)\\/([\\w\\.-]+)/i'), array(array('NAME', 'Netscape'), 'VERSION'), array('/(swiftfox)/i', '/(icedragon|iceweasel|camino|chimera|fennec|maemo\\sbrowser|minimo|conkeror)[\\/\\s]?([\\w\\.\\+]+)/i', '/(firefox|seamonkey|k-meleon|icecat|iceape|firebird|phoenix)\\/([\\w\\.-]+)/i', '/(mozilla)\\/([\\w\\.]+).+rv\\:.+gecko\\/\\d+/i', '/(polaris|lynx|dillo|icab|doris|amaya|w3m|netsurf)[\\/\\s]?([\\w\\.]+)/i', '/(links)\\s\\(([\\w\\.]+)/i', '/(gobrowser)\\/?([\\w\\.]+)*/i', '/(ice\\s?browser)\\/v?([\\w\\._]+)/i', '/(mosaic)[\\/\\s]([\\w\\.]+)/i'), array('NAME', 'VERSION')), 'device' => array(array('/\\((ipad|playbook);[\\w\\s\\);-]+(rim|apple)/i'), array('MODEL', 'VENDOR', array('TYPE', 'TABLET')), array('/applecoremedia\\/[\\w\\.]+ \\((ipad)/'), array('MODEL', array('VENDOR', 'Apple'), array('TYPE', 'TABLET')), array('/(apple\\s{0,1}tv)/i'), array(array('MODEL', 'Apple TV'), array('VENDOR', 'Apple')), array('/(archos)\\s(gamepad2?)/i', '/(hp).+(touchpad)/i', '/(kindle)\\/([\\w\\.]+)/i', '/\\s(nook)[\\w\\s]+build\\/(\\w+)/i', '/(dell)\\s(strea[kpr\\s\\d]*[\\dko])/i'), array('VENDOR', 'MODEL', array('TYPE', 'TABLET')), array('/(kf[A-z]+)\\sbuild\\/[\\w\\.]+.*silk\\//i'), array('MODEL', array('VENDOR', 'Amazon'), array('TYPE', 'TABLET')), array('/(sd|kf)[0349hijorstuw]+\\sbuild\\/[\\w\\.]+.*silk\\//i'), array(array('MODEL', 'mapper_str', $this->aryMaps['device']['amazon']['model']), array('VENDOR', 'Amazon'), array('TYPE', 'MOBILE')), array('/\\((ip[honed|\\s\\w*]+);.+(apple)/i'), array('MODEL', 'VENDOR', array('TYPE', 'MOBILE')), array('/\\((ip[honed|\\s\\w*]+);/i'), array('MODEL', array('VENDOR', 'Apple'), array('TYPE', 'MOBILE')), array('/(blackberry)[\\s-]?(\\w+)/i', '/(blackberry|benq|palm(?=\\-)|sonyericsson|acer|asus|dell|huawei|meizu|motorola|polytron)[\\s_-]?([\\w-]+)*/i', '/(hp)\\s([\\w\\s]+\\w)/i', '/(asus)-?(\\w+)/i'), array('VENDOR', 'MODEL', array('TYPE', 'MOBILE')), array('/\\(bb10;\\s(\\w+)/i'), array('MODEL', array('VENDOR', 'BlackBerry'), array('TYPE', 'MOBILE')), array('/android.+(transfo[prime\\s]{4,10}\\s\\w+|eeepc|slider\\s\\w+|nexus 7)/i'), array('MODEL', array('VENDOR', 'Asus'), array('TYPE', 'TABLET')), array('/(sony)\\s(tablet\\s[ps])\\sbuild\\//i', '/(sony)?(?:sgp.+)\\sbuild\\//i'), array(array('VENDOR', 'Sony'), array('MODEL', 'Xperia Tablet'), array('TYPE', 'TABLET')), array('/(?:sony)?(?:(?:(?:c|d)\\d{4})|(?:so[-l].+))\\sbuild\\//i'), array(array('VENDOR', 'Sony'), array('MODEL', 'Xperia Phone'), array('TYPE', 'MOBILE')), array('/\\s(ouya)\\s/i', '/(nintendo)\\s([wids3u]+)/i'), array('VENDOR', 'MODEL', array('TYPE', 'CONSOLE')), array('/android.+;\\s(shield)\\sbuild/i'), array('MODEL', array('VENDOR', 'Nvidia'), array('TYPE', 'CONSOLE')), array('/(playstation\\s[3portablevi]+)/i'), array(array('VENDOR', 'Sony'), 'MODEL', array('TYPE', 'CONSOLE')), array('/(sprint\\s(\\w+))/i'), array(array('VENDOR', 'mapper_str', $this->aryMaps['device']['sprint']['vendor']), array('MODEL', 'mapper_str', $this->aryMaps['device']['sprint']['model']), array('TYPE', 'MOBILE')), array('/(lenovo)\\s?(S(?:5000|6000)+(?:[-][\\w+]))/i'), array(array('VENDOR', 'Lenovo'), 'MODEL', array('TYPE', 'TABLET')), array('/(htc)[;_\\s-]+([\\w\\s]+(?=\\))|\\w+)*/i', '/(zte)-(\\w+)*/i', '/(alcatel|geeksphone|huawei|lenovo|nexian|panasonic|(?=;\\s)sony)[_\\s-]?([\\w-]+)*/i'), array('VENDOR', array('MODEL', '/_/i', ' '), array('TYPE', 'MOBILE')), array('/(nexus\\s9)/i'), array('MODEL', array('VENDOR', 'HTC'), array('TYPE', 'TABLET')), array('/[\\s\\(;](xbox(?:\\sone)?)[\\s\\);]/i'), array('MODEL', array('VENDOR', 'Microsoft'), array('TYPE', 'CONSOLE')), array('/(kin\\.[onetw]{3})/i'), array(array('MODEL', '/\\./', ' '), array('VENDOR', 'Microsoft'), array('TYPE', 'MOBILE')), array('/\\s(milestone|droid(?:[2-4x]|\\s(?:bionic|x2|pro|razr))?(:?\\s4g)?)[\\w\\s]+build\\//i', '/mot[\\s-]?(\\w+)*/i', '/(XT\\d{3,4}) build\\//i'), array('MODEL', array('VENDOR', 'Motorola'), array('TYPE', 'MOBILE')), array('/android.+\\s((mz60\\d|xoom[\\s2]{0,2}))\\sbuild\\//i'), array('MODEL', array('VENDOR', 'Motorola'), array('TYPE', 'TABLET')), array('/android.+((sch-i[89]0\\d|shw-m380s|gt-p\\d{4}|gt-n8000|sgh-t8[56]9|nexus 10))/i', '/((SM-T\\w+))/i'), array(array('VENDOR', 'Samsung'), 'MODEL', array('TYPE', 'TABLET')), array('/((s[cgp]h-\\w+|gt-\\w+|galaxy\\snexus|sm-n900))/i', '/(sam[sung]*)[\\s-]*(\\w+-?[\\w-]*)*/i', '/sec-((sgh\\w+))/i'), array(array('VENDOR', 'Samsung'), 'MODEL', array('TYPE', 'MOBILE')), array('/(samsung);smarttv/i'), array('VENDOR', 'MODEL', array('TYPE', 'SMARTTV')), array('/\\(dtv[\\);].+(aquos)/i'), array('MODEL', array('VENDOR', 'Sharp'), array('TYPE', 'SMARTTV')), array('/sie-(\\w+)*/i'), array(array('VENDOR', 'Siemens'), 'MODEL', array('TYPE', 'MOBILE')), array('/(maemo|nokia).*(n900|lumia\\s\\d+)/i', '/(nokia)[\\s_-]?([\\w-]+)*/i'), array(array('VENDOR', 'Nokia'), 'MODEL', array('TYPE', 'MOBILE')), array('/android\\s3\\.[\\s\\w;-]{10}(a\\d{3})/i'), array('MODEL', array('VENDOR', 'Acer'), array('TYPE', 'TABLET')), array('/android\\s3\\.[\\s\\w;-]{10}(lg?)-([06cv9]{3,4})/i'), array(array('VENDOR', 'LG'), 'MODEL', array('TYPE', 'TABLET')), array('/(lg) netcast\\.tv/i'), array('VENDOR', array('TYPE', 'SMARTTV')), array('/(nexus\\s[45])/i', '/lg[e;\\s\\/-]+(\\w+)*/i'), array('MODEL', array('VENDOR', 'LG'), array('TYPE', 'MOBILE')), array('/android.+(ideatab[a-z0-9\\-\\s]+)/i'), array('MODEL', array('VENDOR', 'Lenovo'), array('TYPE', 'TABLET')), array('/linux;.+((jolla));/i'), array('VENDOR', 'MODEL', array('TYPE', 'MOBILE')), array('/((pebble))app\\/[\\d\\.]+\\s/i'), array('VENDOR', 'MODEL', array('TYPE', 'WEARABLE')), array('/android.+;\\s(glass)\\s\\d/i'), array('MODEL', array('VENDOR', 'Google'), array('TYPE', 'WEARABLE')), array('/android.+(\\w+)\\s+build\\/hm\\1/i', '/android.+(hm[\\s\\-_]*note?[\\s_]*(?:\\d\\w)?)\\s+build/i', '/android.+(mi[\\s\\-_]*(?:one|one[\\s_]plus)?[\\s_]*(?:\\d\\w)?)\\s+build/i'), array(array('MODEL', '/_/', ' '), array('VENDOR', 'Xiaomi'), array('TYPE', 'MOBILE')), array('/(mobile|tablet);.+rv\\:.+gecko\\//i'), array(array('TYPE', 'util.lowerize'), 'VENDOR', 'MODEL')), 'os' => array(array('/microsoft\\s(windows)\\s(vista|xp)/i'), array('NAME', 'VERSION'), array('/(windows)\\snt\\s6\\.2;\\s(arm)/i', '/(windows\\sphone(?:\\sos)*|windows\\smobile|windows)[\\s\\/]?([ntce\\d\\.\\s]+\\w)/i'), array('NAME', array('VERSION', 'mapper_str', $this->aryMaps['os']['windows']['version'])), array('/(win(?=3|9|n)|win\\s9x\\s)([nt\\d\\.]+)/i'), array(array('NAME', 'Windows'), array('VERSION', 'mapper_str', $this->aryMaps['os']['windows']['version'])), array('/\\((bb)(10);/i'), array(array('NAME', 'BlackBerry'), 'VERSION'), array('/(blackberry)\\w*\\/?([\\w\\.]+)*/i', '/(tizen)[\\/\\s]([\\w\\.]+)/i', '/(android|webos|palm\\sos|qnx|bada|rim\\stablet\\sos|meego|contiki)[\\/\\s-]?([\\w\\.]+)*/i', '/linux;.+(sailfish);/i'), array('NAME', 'VERSION'), array('/(symbian\\s?os|symbos|s60(?=;))[\\/\\s-]?([\\w\\.]+)*/i'), array(array('NAME', 'Symbian'), 'VERSION'), array('/\\((series40);/i'), array('NAME'), array('/mozilla.+\\(mobile;.+gecko.+firefox/i'), array(array('NAME', 'Firefox OS'), 'VERSION'), array('/(nintendo|playstation)\\s([wids3portablevu]+)/i', '/(mint)[\\/\\s\\(]?(\\w+)*/i', '/(mageia|vectorlinux)[;\\s]/i', '/(joli|[kxln]?ubuntu|debian|[open]*suse|gentoo|arch|slackware|fedora|mandriva|centos|pclinuxos|redhat|zenwalk)[\\/\\s-]?([\\w\\.-]+)*/i', '/(hurd|linux)\\s?([\\w\\.]+)*/i', '/(gnu)\\s?([\\w\\.]+)*/i'), array('NAME', 'VERSION'), array('/(cros)\\s[\\w]+\\s([\\w\\.]+\\w)/i'), array(array('NAME', 'Chromium OS'), 'VERSION'), array('/(sunos)\\s?([\\w\\.]+\\d)*/i'), array(array('NAME', 'Solaris'), 'VERSION'), array('/\\s([frentopc-]{0,4}bsd|dragonfly)\\s?([\\w\\.]+)*/i'), array('NAME', 'VERSION'), array('/(ip[honead]+)(?:.*os\\s*([\\w]+)*\\slike\\smac|;\\sopera)/i'), array(array('NAME', 'iOS'), array('VERSION', '/_/i', '.')), array('/(mac\\sos\\sx)\\s?([\\w\\s\\.]+\\w)*/i', '/(macintosh|mac(?=_powerpc)\\s)/i'), array(array('NAME', 'Mac OS'), array('VERSION', '/_/i', '.')), array('/((?:open)?solaris)[\\/\\s-]?([\\w\\.]+)*/i', '/(haiku)\\s(\\w+)/i', '/(aix)\\s((\\d)(?=\\.|\\)|\\s)[\\w\\.]*)*/i', '/(plan\\s9|minix|beos|os\\/2|amigaos|morphos|risc\\sos|openvms)/i', '/(unix)\\s?([\\w\\.]+)*/i'), array('NAME', 'VERSION')));
		$this->strUserAgent = $strOperateUA;
	}
	
	
	public function setUA($strOperateUA)
	{
		$this->strUserAgent = $strOperateUA;
	}
	
	
	public function getBrowser()
	{
		$aryBrowser = array_merge($this->aryBrowserProp, $this->applyRegex($this->aryRegexes['browser']));
		$parts = explode('.', $aryBrowser['VERSION']);
		$aryBrowser['major'] = $parts[0];
		return $aryBrowser;
	}
	
	
	public function getOS()
	{
		return array_merge($this->aryOS_Prop, $this->applyRegex($this->aryRegexes['os']));
	}
	
	
	public function getDevice()
	{
		return array_merge($this->aryDeviceProp, $this->applyRegex($this->aryRegexes['device']));
	}
	
	
	private function applyRegex($aryRegexSet)
	{
		if ('' == $this->strUserAgent)
		{
			return array();
		}
		
		for ($cntrI = 0; $cntrI < count($aryRegexSet); $cntrI += 2)
		{
			for ($cntrJ = 0; $cntrJ < count($aryRegexSet[$cntrI]); $cntrJ++)
			{
				if (0 < preg_match_all($aryRegexSet[$cntrI][$cntrJ], $this->strUserAgent, $aryMatches))
				{
					$aryResultProp = $aryRegexSet[$cntrI + 1];
					$aryResult = array();
					for ($cntrK = 0; $cntrK < count($aryResultProp); $cntrK++)
					{
						if (!isset($aryMatches[$cntrK + 1][0]))
						{
							$strFinalValue = '';
						}
						else
						{
							$strFinalValue = $aryMatches[$cntrK + 1][0];
						}
						
						if (is_array($aryResultProp[$cntrK]))
						{
							switch (count($aryResultProp[$cntrK]))
							{
								case 2:
									if (function_exists($aryResultProp[$cntrK][1]))
									{
										$strFinalValue = ${$aryResultProp[$cntrK][1]}($strFinalValue);
									}
									else
									{
										$strFinalValue = $aryResultProp[$cntrK][1];
									}
									
									break;
								case 3:
									if (function_exists($aryResultProp[$cntrK][1]))
									{
										$strFinalValue = $aryResultProp[$cntrK][1]($strFinalValue, $aryResultProp[$cntrK][2]);
									}
									else
									{
										$strFinalValue = preg_replace($aryResultProp[$cntrK][1], $aryResultProp[$cntrK][2], $strFinalValue);
									}
									
									break;
								case 4:
									if (function_exists($aryResultProp[$cntrK][3]))
									{
										$strFinalValue = ${$aryResultProp[$cntrK][3]}($strFinalValue, $aryResultProp[$cntrK][1], $aryResultProp[$cntrK][2]);
									}
							
							}
							
							$aryResult[$aryResultProp[$cntrK][0]] = $strFinalValue;
						}
						else
						{
							$aryResult[$aryResultProp[$cntrK]] = $strFinalValue;
						}
					
					}
					
					return $aryResult;
					break;
				}
			
			}
		
		}
		
		return array();
	}

}

function mapper_str($strToCheck, $aryMap)
{
	foreach ($aryMap as $keyMap => $valMap)
	{
		if (is_array($valMap) && count($valMap) > 0)
		{
			foreach ($valMap as $valStrMap)
			{
				if (false !== stripos($strToCheck, $valStrMap))
				{
					return $keyMap;
				}
			
			}
		
		}
		else
		{
			if (false !== stripos($strToCheck, $valMap))
			{
				return $keyMap;
			}
		
		}
	
	}
	
	return $strToCheck;
}