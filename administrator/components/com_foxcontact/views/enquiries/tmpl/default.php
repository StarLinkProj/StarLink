<?php defined("_JEXEC") or die(file_get_contents("index.html"));
/**
 * @package   Fox Contact for Joomla
 * @copyright Copyright (c) 2010 - 2015 Demis Palma. All rights reserved.
 * @license   Distributed under the terms of the GNU General Public License GNU/GPL v3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see       Documentation: http://www.fox.ra.it/forum/2-documentation.html
 */

JHtml::_("bootstrap.tooltip");
JHtml::_("behavior.multiselect");
JHtml::_("formbehavior.chosen", "select");

$listOrder = $this->escape($this->state->get("list.ordering"));
$listDirn = $this->escape($this->state->get("list.direction"));
?>

<form action="<?php echo JRoute::_("index.php?option=com_foxcontact&view=enquiries"); ?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

			<!-- Search toolbar -->
			<?php echo JLayoutHelper::render("searchtools.default", array("view" => $this)) ?>

			<?php if (empty($this->items)) : ?>
				<div class="alert alert-no-items">
					<?php echo JText::_("JGLOBAL_NO_MATCHING_RESULTS"); ?>
				</div>
			<?php else : ?>
				<table id="enquiries" class="table table-striped">
					<thead>
					<tr>
						<th width="1%">
							<?php echo JHtml::_("grid.checkall"); ?>
						</th>
						<th width="1%">
							<?php echo JHtml::_("searchtools.sort", "JDATE", "a.date", $listDirn, $listOrder); ?>
						</th>
						<th width="1%">
							<?php echo JText::_("COM_FOXCONTACT_FROM") ?>
						</th>
						<th width="1%" class="hidden-phone nowrap">
							<?php echo JText::_("COM_FOXCONTACT_REFERRING_FORM"); ?>
						</th>
						<th width="95%" class="hidden-phone nowrap">
							<?php echo JText::_("COM_FOXCONTACT_REFERRER"); ?>
						</th>
						<th width="1%" class="hidden-phone">
							<?php echo JText::_("COM_FOXCONTACT_EXPORTED"); ?>
						</th>

					</tr>
					</thead>
					<tfoot>
					<tr>
						<td colspan="6">
							<?php echo $this->pagination->getListFooter(); ?>
						</td>
					</tr>
					</tfoot>
					<tbody>
					<?php foreach ($this->items as $i => $item) :
						$ordering = ($listOrder == "ordering");
						?>
						<tr class="row<?php echo $i % 2 . $item->class; ?>">

							<td class="center">
								<?php echo JHtml::_("grid.id", $i, $item->id); ?>
							</td>
							<td class="nowrap">
								<div class="small pull-left">
									<?php echo JFactory::getDate($item->date)->format("d M Y") ?>
								</div>
							</td>
							<td class="nowrap">
								<div class="pull-left sender">
									<?php foreach ($item->from_data as $from_data) : ?>
										<div class="small">
											<?php echo $from_data ?>
										</div>
									<?php endforeach ?>
								</div>
							</td>
							<td class="hidden-phone nowrap">
								<div class="small pull-left">
									<?php echo $item->form ?>
								</div>
							</td>
							<td class="hidden-phone nowrap">
								<div class="small pull-left">
									<?php
									$url = $this->escape($item->url);
									// parse_url() can return null. Example: "http://www.site.com", therefore we need to explicit set "/" as default value
									$path = parse_url($url, PHP_URL_PATH) or $path = "/";
									echo '<a href="' . $url . '">' . $path . "</a>";
									?>
								</div>
							</td>
							<td class="hidden-phone">
								<div class="small pull-left">
									<?php echo JText::_((bool)$item->exported ? "JYES" : "JNO") ?>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif; ?>

			<!-- Checked items counter -->
			<input type="hidden" name="boxchecked" value="0"/>
			<!-- Joomla.submitform() -->
			<input type="hidden" name="task" value=""/>

			<?php echo JHtml::_("form.token"); ?>
		</div>
</form>
