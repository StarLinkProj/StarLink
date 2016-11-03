<?php /**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
namespace Pelago;

defined('_JEXEC') or die(file_get_contents('index.html'));

class Emogrifier
{
	const CACHE_KEY_CSS = 0;
	const CACHE_KEY_SELECTOR = 1;
	const CACHE_KEY_XPATH = 2;
	const CACHE_KEY_CSS_DECLARATIONS_BLOCK = 3;
	const CACHE_KEY_COMBINED_STYLES = 4;
	const INDEX = 0;
	const MULTIPLIER = 1;
	const ID_ATTRIBUTE_MATCHER = '/(\\w+)?\\#([\\w\\-]+)/';
	const CLASS_ATTRIBUTE_MATCHER = '/(\\w+|[\\*\\]])?((\\.[\\w\\-]+)+)/';
	const CONTENT_TYPE_META_TAG = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	const DEFAULT_DOCUMENT_TYPE = '<!DOCTYPE html>';
	private $html = '';
	private $css = '';
	private $excludedSelectors = array();
	private $unprocessableHtmlTags = array('wbr');
	private $allowedMediaTypes = array('all' => true, 'screen' => true, 'print' => true);
	private $caches = array(self::CACHE_KEY_CSS => array(), self::CACHE_KEY_SELECTOR => array(), self::CACHE_KEY_XPATH => array(), self::CACHE_KEY_CSS_DECLARATIONS_BLOCK => array(), self::CACHE_KEY_COMBINED_STYLES => array());
	private $visitedNodes = array();
	private $styleAttributesForNodes = array();
	private $isInlineStyleAttributesParsingEnabled = true;
	private $isStyleBlocksParsingEnabled = true;
	private $shouldKeepInvisibleNodes = true;
	
	public function __construct($html = '', $css = '')
	{
		$this->setHtml($html);
		$this->setCss($css);
	}
	
	
	public function __destruct()
	{
		$this->purgeVisitedNodes();
	}
	
	
	public function setHtml($html)
	{
		$this->html = $html;
	}
	
	
	public function setCss($css)
	{
		$this->css = $css;
	}
	
	
	public function emogrify()
	{
		if ($this->html === '')
		{
			throw new \BadMethodCallException('Please set some HTML first before calling emogrify.', 1390393096);
		}
		
		$xmlDocument = $this->createXmlDocument();
		$this->process($xmlDocument);
		return $xmlDocument->saveHTML();
	}
	
	
	public function emogrifyBodyContent()
	{
		if ($this->html === '')
		{
			throw new \BadMethodCallException('Please set some HTML first before calling emogrify.', 1390393096);
		}
		
		$xmlDocument = $this->createXmlDocument();
		$this->process($xmlDocument);
		$innerDocument = new \DOMDocument();
		foreach ($xmlDocument->documentElement->getElementsByTagName('body')->item(0)->childNodes as $childNode)
		{
			$innerDocument->appendChild($innerDocument->importNode($childNode, true));
		}
		
		return $innerDocument->saveHTML();
	}
	
	
	protected function process($xmlDocument)
	{
		$xpath = new \DOMXPath($xmlDocument);
		$this->clearAllCaches();
		$this->purgeVisitedNodes();
		$nodesWithStyleAttributes = $xpath->query('//*[@style]');
		if ($nodesWithStyleAttributes !== false)
		{
			foreach ($nodesWithStyleAttributes as $node)
			{
				if ($this->isInlineStyleAttributesParsingEnabled)
				{
					$this->normalizeStyleAttributes($node);
				}
				else
				{
					$node->removeAttribute('style');
				}
			
			}
		
		}
		
		$allCss = $this->css;
		if ($this->isStyleBlocksParsingEnabled)
		{
			$allCss .= $this->getCssFromAllStyleNodes($xpath);
		}
		
		$cssParts = $this->splitCssAndMediaQuery($allCss);
		$excludedNodes = $this->getNodesToExclude($xpath);
		$cssRules = $this->parseCssRules($cssParts['css']);
		foreach ($cssRules as $cssRule)
		{
			$nodesMatchingCssSelectors = $xpath->query($this->translateCssToXpath($cssRule['selector']));
			if ($nodesMatchingCssSelectors === false)
			{
				continue;
			}
			
			foreach ($nodesMatchingCssSelectors as $node)
			{
				if (in_array($node, $excludedNodes, true))
				{
					continue;
				}
				
				if ($node->hasAttribute('style'))
				{
					$oldStyleDeclarations = $this->parseCssDeclarationsBlock($node->getAttribute('style'));
				}
				else
				{
					$oldStyleDeclarations = array();
				}
				
				$newStyleDeclarations = $this->parseCssDeclarationsBlock($cssRule['declarationsBlock']);
				$node->setAttribute('style', $this->generateStyleStringFromDeclarationsArrays($oldStyleDeclarations, $newStyleDeclarations));
			}
		
		}
		
		if ($this->isInlineStyleAttributesParsingEnabled)
		{
			$this->fillStyleAttributesWithMergedStyles();
		}
		
		if ($this->shouldKeepInvisibleNodes)
		{
			$this->removeInvisibleNodes($xpath);
		}
		
		$this->copyCssWithMediaToStyleNode($xmlDocument, $xpath, $cssParts['media']);
	}
	
	
	private function parseCssRules($css)
	{
		$cssKey = md5($css);
		if (!isset($this->caches[self::CACHE_KEY_CSS][$cssKey]))
		{
			preg_match_all('/(?:^|[\\s^{}]*)([^{]+){([^}]*)}/mis', $css, $matches, PREG_SET_ORDER);
			$cssRules = array();
			foreach ($matches as $key => $cssRule)
			{
				$cssDeclaration = trim($cssRule[2]);
				if ($cssDeclaration === '')
				{
					continue;
				}
				
				$selectors = explode(',', $cssRule[1]);
				foreach ($selectors as $selector)
				{
					if (strpos($selector, ':') !== false && !preg_match('/:\\S+\\-(child|type\\()/i', $selector))
					{
						continue;
					}
					
					$cssRules[] = array('selector' => trim($selector), 'declarationsBlock' => $cssDeclaration, 'line' => $key);
				}
			
			}
			
			usort($cssRules, array($this, 'sortBySelectorPrecedence'));
			$this->caches[self::CACHE_KEY_CSS][$cssKey] = $cssRules;
		}
		
		return $this->caches[self::CACHE_KEY_CSS][$cssKey];
	}
	
	
	public function disableInlineStyleAttributesParsing()
	{
		$this->isInlineStyleAttributesParsingEnabled = false;
	}
	
	
	public function disableStyleBlocksParsing()
	{
		$this->isStyleBlocksParsingEnabled = false;
	}
	
	
	public function disableInvisibleNodeRemoval()
	{
		$this->shouldKeepInvisibleNodes = false;
	}
	
	
	private function clearAllCaches()
	{
		$this->clearCache(self::CACHE_KEY_CSS);
		$this->clearCache(self::CACHE_KEY_SELECTOR);
		$this->clearCache(self::CACHE_KEY_XPATH);
		$this->clearCache(self::CACHE_KEY_CSS_DECLARATIONS_BLOCK);
		$this->clearCache(self::CACHE_KEY_COMBINED_STYLES);
	}
	
	
	private function clearCache($key)
	{
		$allowedCacheKeys = array(self::CACHE_KEY_CSS, self::CACHE_KEY_SELECTOR, self::CACHE_KEY_XPATH, self::CACHE_KEY_CSS_DECLARATIONS_BLOCK, self::CACHE_KEY_COMBINED_STYLES);
		if (!in_array($key, $allowedCacheKeys, true))
		{
			throw new \InvalidArgumentException('Invalid cache key: ' . $key, 1391822035);
		}
		
		$this->caches[$key] = array();
	}
	
	
	private function purgeVisitedNodes()
	{
		$this->visitedNodes = array();
		$this->styleAttributesForNodes = array();
	}
	
	
	public function addUnprocessableHtmlTag($tagName)
	{
		$this->unprocessableHtmlTags[] = $tagName;
	}
	
	
	public function removeUnprocessableHtmlTag($tagName)
	{
		$key = array_search($tagName, $this->unprocessableHtmlTags, true);
		if ($key !== false)
		{
			unset($this->unprocessableHtmlTags[$key]);
		}
	
	}
	
	
	public function addAllowedMediaType($mediaName)
	{
		$this->allowedMediaTypes[$mediaName] = true;
	}
	
	
	public function removeAllowedMediaType($mediaName)
	{
		if (isset($this->allowedMediaTypes[$mediaName]))
		{
			unset($this->allowedMediaTypes[$mediaName]);
		}
	
	}
	
	
	public function addExcludedSelector($selector)
	{
		$this->excludedSelectors[$selector] = true;
	}
	
	
	public function removeExcludedSelector($selector)
	{
		if (isset($this->excludedSelectors[$selector]))
		{
			unset($this->excludedSelectors[$selector]);
		}
	
	}
	
	
	private function removeInvisibleNodes($xpath)
	{
		$nodesWithStyleDisplayNone = $xpath->query('//*[contains(translate(translate(@style," ",""),"NOE","noe"),"display:none")]');
		if ($nodesWithStyleDisplayNone->length === 0)
		{
			return;
		}
		
		foreach ($nodesWithStyleDisplayNone as $node)
		{
			if ($node->parentNode && is_callable(array($node->parentNode, 'removeChild')))
			{
				$node->parentNode->removeChild($node);
			}
		
		}
	
	}
	
	
	private function normalizeStyleAttributes($node)
	{
		$normalizedOriginalStyle = preg_replace_callback('/[A-z\\-]+(?=\\:)/S', function ($m)
		{
			return strtolower($m[0]);
		}, $node->getAttribute('style'));
		$nodePath = $node->getNodePath();
		if (!isset($this->styleAttributesForNodes[$nodePath]))
		{
			$this->styleAttributesForNodes[$nodePath] = $this->parseCssDeclarationsBlock($normalizedOriginalStyle);
			$this->visitedNodes[$nodePath] = $node;
		}
		
		$node->setAttribute('style', $normalizedOriginalStyle);
	}
	
	
	private function fillStyleAttributesWithMergedStyles()
	{
		foreach ($this->styleAttributesForNodes as $nodePath => $styleAttributesForNode)
		{
			$node = $this->visitedNodes[$nodePath];
			$currentStyleAttributes = $this->parseCssDeclarationsBlock($node->getAttribute('style'));
			$node->setAttribute('style', $this->generateStyleStringFromDeclarationsArrays($currentStyleAttributes, $styleAttributesForNode));
		}
	
	}
	
	
	private function generateStyleStringFromDeclarationsArrays($oldStyles, $newStyles)
	{
		$combinedStyles = array_merge($oldStyles, $newStyles);
		$cacheKey = serialize($combinedStyles);
		if (isset($this->caches[self::CACHE_KEY_COMBINED_STYLES][$cacheKey]))
		{
			return $this->caches[self::CACHE_KEY_COMBINED_STYLES][$cacheKey];
		}
		
		foreach ($oldStyles as $attributeName => $attributeValue)
		{
			if (isset($newStyles[$attributeName]) && strtolower(substr($attributeValue, -10)) === '!important')
			{
				$combinedStyles[$attributeName] = $attributeValue;
			}
		
		}
		
		$style = '';
		foreach ($combinedStyles as $attributeName => $attributeValue)
		{
			$style .= strtolower(trim($attributeName)) . ': ' . trim($attributeValue) . '; ';
		}
		
		$trimmedStyle = rtrim($style);
		$this->caches[self::CACHE_KEY_COMBINED_STYLES][$cacheKey] = $trimmedStyle;
		return $trimmedStyle;
	}
	
	
	private function copyCssWithMediaToStyleNode($xmlDocument, $xpath, $css)
	{
		if ($css === '')
		{
			return;
		}
		
		$mediaQueriesRelevantForDocument = array();
		foreach ($this->extractMediaQueriesFromCss($css) as $mediaQuery)
		{
			foreach ($this->parseCssRules($mediaQuery['css']) as $selector)
			{
				if ($this->existsMatchForCssSelector($xpath, $selector['selector']))
				{
					$mediaQueriesRelevantForDocument[] = $mediaQuery['query'];
					break;
				}
			
			}
		
		}
		
		$this->addStyleElementToDocument($xmlDocument, implode($mediaQueriesRelevantForDocument));
	}
	
	
	private function extractMediaQueriesFromCss($css)
	{
		preg_match_all('#(?<query>@media[^{]*\\{(?<css>(.*?)\\})(\\s*)\\})#s', $css, $mediaQueries);
		$result = array();
		foreach (array_keys($mediaQueries['css']) as $key)
		{
			$result[] = array('css' => $mediaQueries['css'][$key], 'query' => $mediaQueries['query'][$key]);
		}
		
		return $result;
	}
	
	
	private function existsMatchForCssSelector($xpath, $cssSelector)
	{
		$nodesMatchingSelector = $xpath->query($this->translateCssToXpath($cssSelector));
		return $nodesMatchingSelector !== false && $nodesMatchingSelector->length !== 0;
	}
	
	
	private function getCssFromAllStyleNodes($xpath)
	{
		$styleNodes = $xpath->query('//style');
		if ($styleNodes === false)
		{
			return '';
		}
		
		$css = '';
		foreach ($styleNodes as $styleNode)
		{
			$css .= "\n\n" . $styleNode->nodeValue;
			$styleNode->parentNode->removeChild($styleNode);
		}
		
		return $css;
	}
	
	
	protected function addStyleElementToDocument($document, $css)
	{
		$styleElement = $document->createElement('style', $css);
		$styleAttribute = $document->createAttribute('type');
		$styleAttribute->value = 'text/css';
		$styleElement->appendChild($styleAttribute);
		$head = $this->getOrCreateHeadElement($document);
		$head->appendChild($styleElement);
	}
	
	
	private function getOrCreateHeadElement($document)
	{
		$head = $document->getElementsByTagName('head')->item(0);
		if ($head === null)
		{
			$head = $document->createElement('head');
			$html = $document->getElementsByTagName('html')->item(0);
			$html->insertBefore($head, $document->getElementsByTagName('body')->item(0));
		}
		
		return $head;
	}
	
	
	private function splitCssAndMediaQuery($css)
	{
		$cssWithoutComments = preg_replace('/\\/\\*.*\\*\\//sU', '', $css);
		$mediaTypesExpression = '';
		if (!empty($this->allowedMediaTypes))
		{
			$mediaTypesExpression = '|' . implode('|', array_keys($this->allowedMediaTypes));
		}
		
		$media = '';
		$cssForAllowedMediaTypes = preg_replace_callback('#@media\\s+(?:only\\s)?(?:[\\s{\\(]' . $mediaTypesExpression . ')\\s?[^{]+{.*}\\s*}\\s*#misU', function ($matches) use(&$media)
		{
			$media .= $matches[0];
		}, $cssWithoutComments);
		$search = array('import directives' => '/^\\s*@import\\s[^;]+;/misU', 'remaining media enclosures' => '/^\\s*@media\\s[^{]+{(.*)}\\s*}\\s/misU');
		$cleanedCss = preg_replace($search, '', $cssForAllowedMediaTypes);
		return array('css' => $cleanedCss, 'media' => $media);
	}
	
	
	private function createXmlDocument()
	{
		$xmlDocument = new \DOMDocument();
		$xmlDocument->encoding = 'UTF-8';
		$xmlDocument->strictErrorChecking = false;
		$xmlDocument->formatOutput = true;
		$libXmlState = libxml_use_internal_errors(true);
		$xmlDocument->loadHTML($this->getUnifiedHtml());
		libxml_clear_errors();
		libxml_use_internal_errors($libXmlState);
		$xmlDocument->normalizeDocument();
		return $xmlDocument;
	}
	
	
	private function getUnifiedHtml()
	{
		$htmlWithoutUnprocessableTags = $this->removeUnprocessableTags($this->html);
		$htmlWithDocumentType = $this->ensureDocumentType($htmlWithoutUnprocessableTags);
		return $this->addContentTypeMetaTag($htmlWithDocumentType);
	}
	
	
	private function removeUnprocessableTags($html)
	{
		if (empty($this->unprocessableHtmlTags))
		{
			return $html;
		}
		
		$unprocessableHtmlTags = implode('|', $this->unprocessableHtmlTags);
		return preg_replace('/<\\/?(' . $unprocessableHtmlTags . ')[^>]*>/i', '', $html);
	}
	
	
	private function ensureDocumentType($html)
	{
		$hasDocumentType = stripos($html, '<!DOCTYPE') !== false;
		if ($hasDocumentType)
		{
			return $html;
		}
		
		return self::DEFAULT_DOCUMENT_TYPE . $html;
	}
	
	
	private function addContentTypeMetaTag($html)
	{
		$hasContentTypeMetaTag = stristr($html, 'Content-Type') !== false;
		if ($hasContentTypeMetaTag)
		{
			return $html;
		}
		
		$hasHeadTag = stripos($html, '<head') !== false;
		$hasHtmlTag = stripos($html, '<html') !== false;
		if ($hasHeadTag)
		{
			$reworkedHtml = preg_replace('/<head(.*?)>/i', '<head$1>' . self::CONTENT_TYPE_META_TAG, $html);
		}
		elseif ($hasHtmlTag)
		{
			$reworkedHtml = preg_replace('/<html(.*?)>/i', '<html$1><head>' . self::CONTENT_TYPE_META_TAG . '</head>', $html);
		}
		else
		{
			$reworkedHtml = self::CONTENT_TYPE_META_TAG . $html;
		}
		
		return $reworkedHtml;
	}
	
	
	private function sortBySelectorPrecedence($a, $b)
	{
		$precedenceA = $this->getCssSelectorPrecedence($a['selector']);
		$precedenceB = $this->getCssSelectorPrecedence($b['selector']);
		$precedenceForEquals = $a['line'] < $b['line'] ? -1 : 1;
		$precedenceForNotEquals = $precedenceA < $precedenceB ? -1 : 1;
		return $precedenceA === $precedenceB ? $precedenceForEquals : $precedenceForNotEquals;
	}
	
	
	private function getCssSelectorPrecedence($selector)
	{
		$selectorKey = md5($selector);
		if (!isset($this->caches[self::CACHE_KEY_SELECTOR][$selectorKey]))
		{
			$precedence = 0;
			$value = 100;
			$search = array('\\#', '\\.', '');
			foreach ($search as $s)
			{
				if (trim($selector) === '')
				{
					break;
				}
				
				$number = 0;
				$selector = preg_replace('/' . $s . '\\w+/', '', $selector, -1, $number);
				$precedence += $value * $number;
				$value /= 10;
			}
			
			$this->caches[self::CACHE_KEY_SELECTOR][$selectorKey] = $precedence;
		}
		
		return $this->caches[self::CACHE_KEY_SELECTOR][$selectorKey];
	}
	
	
	private function translateCssToXpath($cssSelector)
	{
		$paddedSelector = ' ' . $cssSelector . ' ';
		$lowercasePaddedSelector = preg_replace_callback('/\\s+\\w+\\s+/', function ($matches)
		{
			return strtolower($matches[0]);
		}, $paddedSelector);
		$trimmedLowercaseSelector = trim($lowercasePaddedSelector);
		$xpathKey = md5($trimmedLowercaseSelector);
		if (!isset($this->caches[self::CACHE_KEY_XPATH][$xpathKey]))
		{
			$cssSelectorMatches = array('child' => '/\\s+>\\s+/', 'adjacent sibling' => '/\\s+\\+\\s+/', 'descendant' => '/\\s+/', ':first-child' => '/([^\\/]+):first-child/i', ':last-child' => '/([^\\/]+):last-child/i', 'attribute only' => '/^\\[(\\w+|\\w+\\=[\'"]?\\w+[\'"]?)\\]/', 'attribute' => '/(\\w)\\[(\\w+)\\]/', 'exact attribute' => '/(\\w)\\[(\\w+)\\=[\'"]?(\\w+)[\'"]?\\]/');
			$xPathReplacements = array('child' => '/', 'adjacent sibling' => '/following-sibling::*[1]/self::', 'descendant' => '//', ':first-child' => '\\1/*[1]', ':last-child' => '\\1/*[last()]', 'attribute only' => '*[@\\1]', 'attribute' => '\\1[@\\2]', 'exact attribute' => '\\1[@\\2="\\3"]');
			$roughXpath = '//' . preg_replace($cssSelectorMatches, $xPathReplacements, $trimmedLowercaseSelector);
			$xpathWithIdAttributeMatchers = preg_replace_callback(self::ID_ATTRIBUTE_MATCHER, array($this, 'matchIdAttributes'), $roughXpath);
			$xpathWithIdAttributeAndClassMatchers = preg_replace_callback(self::CLASS_ATTRIBUTE_MATCHER, array($this, 'matchClassAttributes'), $xpathWithIdAttributeMatchers);
			$xpathWithIdAttributeAndClassMatchers = preg_replace_callback('/([^\\/]+):nth-child\\(\\s*(odd|even|[+\\-]?\\d|[+\\-]?\\d?n(\\s*[+\\-]\\s*\\d)?)\\s*\\)/i', array($this, 'translateNthChild'), $xpathWithIdAttributeAndClassMatchers);
			$finalXpath = preg_replace_callback('/([^\\/]+):nth-of-type\\(\\s*(odd|even|[+\\-]?\\d|[+\\-]?\\d?n(\\s*[+\\-]\\s*\\d)?)\\s*\\)/i', array($this, 'translateNthOfType'), $xpathWithIdAttributeAndClassMatchers);
			$this->caches[self::CACHE_KEY_SELECTOR][$xpathKey] = $finalXpath;
		}
		
		return $this->caches[self::CACHE_KEY_SELECTOR][$xpathKey];
	}
	
	
	private function matchIdAttributes($match)
	{
		return ($match[1] !== '' ? $match[1] : '*') . '[@id="' . $match[2] . '"]';
	}
	
	
	private function matchClassAttributes($match)
	{
		return ($match[1] !== '' ? $match[1] : '*') . '[contains(concat(" ",@class," "),concat(" ","' . implode('"," "))][contains(concat(" ",@class," "),concat(" ","', explode('.', substr($match[2], 1))) . '"," "))]';
	}
	
	
	private function translateNthChild($match)
	{
		$parseResult = $this->parseNth($match);
		if (isset($parseResult[self::MULTIPLIER]))
		{
			if ($parseResult[self::MULTIPLIER] < 0)
			{
				$parseResult[self::MULTIPLIER] = abs($parseResult[self::MULTIPLIER]);
				$xPathExpression = sprintf('*[(last() - position()) mod %u = %u]/self::%s', $parseResult[self::MULTIPLIER], $parseResult[self::INDEX], $match[1]);
			}
			else
			{
				$xPathExpression = sprintf('*[position() mod %u = %u]/self::%s', $parseResult[self::MULTIPLIER], $parseResult[self::INDEX], $match[1]);
			}
		
		}
		else
		{
			$xPathExpression = sprintf('*[%u]/self::%s', $parseResult[self::INDEX], $match[1]);
		}
		
		return $xPathExpression;
	}
	
	
	private function translateNthOfType($match)
	{
		$parseResult = $this->parseNth($match);
		if (isset($parseResult[self::MULTIPLIER]))
		{
			if ($parseResult[self::MULTIPLIER] < 0)
			{
				$parseResult[self::MULTIPLIER] = abs($parseResult[self::MULTIPLIER]);
				$xPathExpression = sprintf('%s[(last() - position()) mod %u = %u]', $match[1], $parseResult[self::MULTIPLIER], $parseResult[self::INDEX]);
			}
			else
			{
				$xPathExpression = sprintf('%s[position() mod %u = %u]', $match[1], $parseResult[self::MULTIPLIER], $parseResult[self::INDEX]);
			}
		
		}
		else
		{
			$xPathExpression = sprintf('%s[%u]', $match[1], $parseResult[self::INDEX]);
		}
		
		return $xPathExpression;
	}
	
	
	private function parseNth($match)
	{
		if (in_array(strtolower($match[2]), array('even', 'odd'), true))
		{
			$index = strtolower($match[2]) === 'even' ? 0 : 1;
			return array(self::MULTIPLIER => 2, self::INDEX => $index);
		}
		
		if (stripos($match[2], 'n') === false)
		{
			$index = (int) str_replace(' ', '', $match[2]);
			return array(self::INDEX => $index);
		}
		
		if (isset($match[3]))
		{
			$multipleTerm = str_replace($match[3], '', $match[2]);
			$index = (int) str_replace(' ', '', $match[3]);
		}
		else
		{
			$multipleTerm = $match[2];
			$index = 0;
		}
		
		$multiplier = str_ireplace('n', '', $multipleTerm);
		if ($multiplier === '')
		{
			$multiplier = 1;
		}
		elseif ($multiplier === '0')
		{
			return array(self::INDEX => $index);
		}
		else
		{
			$multiplier = (int) $multiplier;
		}
		
		while ($index < 0)
		{
			$index += abs($multiplier);
		}
		
		return array(self::MULTIPLIER => $multiplier, self::INDEX => $index);
	}
	
	
	private function parseCssDeclarationsBlock($cssDeclarationsBlock)
	{
		if (isset($this->caches[self::CACHE_KEY_CSS_DECLARATIONS_BLOCK][$cssDeclarationsBlock]))
		{
			return $this->caches[self::CACHE_KEY_CSS_DECLARATIONS_BLOCK][$cssDeclarationsBlock];
		}
		
		$properties = array();
		$declarations = preg_split('/;(?!base' . '64|charset)/', $cssDeclarationsBlock);
		foreach ($declarations as $declaration)
		{
			$matches = array();
			if (!preg_match('/^([A-Za-z\\-]+)\\s*:\\s*(.+)$/', trim($declaration), $matches))
			{
				continue;
			}
			
			$propertyName = strtolower($matches[1]);
			$propertyValue = $matches[2];
			$properties[$propertyName] = $propertyValue;
		}
		
		$this->caches[self::CACHE_KEY_CSS_DECLARATIONS_BLOCK][$cssDeclarationsBlock] = $properties;
		return $properties;
	}
	
	
	private function getNodesToExclude($xpath)
	{
		$excludedNodes = array();
		foreach (array_keys($this->excludedSelectors) as $selectorToExclude)
		{
			foreach ($xpath->query($this->translateCssToXpath($selectorToExclude)) as $node)
			{
				$excludedNodes[] = $node;
			}
		
		}
		
		return $excludedNodes;
	}

}