<?php defined("_JEXEC") or die(file_get_contents("index.html"));
/**
 * @package Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see Documentation: http://www.fox.ra.it/forum/2-documentation.html
 * based on /layouts/joomla/searchtools/default.php
 */


// Receive overridable options
$displayData["options"] = !empty($displayData["options"]) ? $displayData["options"] : array();

// Set some basic options
$customOptions = array(
	"filtersHidden" => isset($displayData["options"]["filtersHidden"]) ? $displayData["options"]["filtersHidden"] : empty($displayData["view"]->activeFilters),
	"defaultLimit" => isset($displayData["options"]["defaultLimit"]) ? $displayData["options"]["defaultLimit"] : JFactory::getConfig()->get("list_limit", 20),
	"searchFieldSelector" => "#filter_search",
	"orderFieldSelector" => "#list_fullordering"
);

$displayData["options"] = array_unique(array_merge($customOptions, $displayData["options"]));

$formSelector = !empty($displayData["options"]["formSelector"]) ? $displayData["options"]["formSelector"] : "#adminForm";

// Load search tools
JHtml::_("searchtools.form", $formSelector, $displayData["options"]);
?>

<div class="js-stools clearfix">

	<!-- Sort field and items per page -->
	<div class="js-stools-container-list hidden-phone hidden-tablet">
		<?php foreach ($displayData["view"]->filterForm->getGroup("list") as $field) : ?>
			<div class="js-stools-field-list">
				<?php echo $field->label, $field->input ?>
			</div>
		<?php endforeach ?>
	</div>

	<!-- Filters div -->
	<div class="clearfix">
		<?php foreach ($displayData["view"]->filterForm->getGroup("filter") as $field) : ?>
			<div class="js-stools-field-filter">
				<?php echo $field->label, $field->input ?>
			</div>
		<?php endforeach ?>
	</div>

</div>