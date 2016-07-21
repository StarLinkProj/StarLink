<?php defined("_JEXEC") or die(file_get_contents("index.html"));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */
?>


<h2><?php echo JText::_("COM_FOXCONTACT_ERR_PROVIDE_VALID_URL") ?></h2>

<ul>
	<?php foreach ($this->valid_items as $valid_item) : ?>
		<li><a href="<?php echo JRoute::_(FoxHtmlLink::getMenuLink($valid_item)) ?>"><?php echo htmlspecialchars($valid_item->title) ?></a></li>
	<?php endforeach ?>
</ul>

<p><a href="http://www.fox.ra.it/forum/22-how-to/1574-hide-the-contact-page-menu-item.html"><?php echo JText::_("COM_FOXCONTACT_READ_MORE") ?></a></p>
