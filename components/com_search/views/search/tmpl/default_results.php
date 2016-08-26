<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php if (preg_match('/\&Itemid\=118/', $_SERVER['REQUEST_URI'] )) : ?>
	<?php
		foreach($this->results as $singleResult) {
			if ($singleResult->catid == 11) {
				$blogResults[] = $singleResult;
			}
		}
		$this->results = $blogResults;
	?>
<?php endif; ?>


<div class="search-results<?php echo $this->pageclass_sfx; ?> items-leading">
<?php foreach ($this->results as $result) : ?>
	<div>
		<div class="page-header">
			<h2>
			<?php if ($result->href) :?>
				<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) :?> target="_blank"<?php endif;?>>
					<?php echo $this->escape($result->title);?>
				</a>
			<?php else:?>
				<?php  echo $this->escape($result->title);?>
			<?php endif; ?>
			</h2>
		</div>
		<div class="blogCatAndDate"><?php echo $result->created; ?></div>
		<?php /*if ($result->section) : */?><!--
			<dd class="result-category">
				<span class="small<?php /*echo $this->pageclass_sfx; */?>">
					(<?php /*echo $this->escape($result->section); */?>)
				</span>
			</dd>
		--><?php /*endif; */?>
		<?php echo $result->text; ?>

		<div class="blogCategoryItemFooter row">
			<div class="blogReadMore col-md-6 col-sm-6 col-xs-12">
				<p class="readmore">
					<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) :?> target="_blank"<?php endif;?>>
						<?php echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');?>
					</a>
				</p>
			</div>
		</div>
	<!--	--><?php //if ($this->params->get('show_date')) : ?>
	<!--		<dd class="result-created--><?php //echo $this->pageclass_sfx; ?><!--">-->
	<!--			--><?php //echo JText::sprintf('JGLOBAL_CREATED_DATE_ON', $result->created); ?>
	<!--		</dd>-->
	<!--	--><?php //endif; ?>
	</div>
<?php endforeach; ?>
</div>

<div class="pagination">
	<?php
		if (preg_match('/\&Itemid\=118/', $_SERVER['REQUEST_URI'] ) && count($this->results) > 20) {
			echo $this->pagination->getPagesLinks();
		} else if (!preg_match('/\&Itemid\=118/', $_SERVER['REQUEST_URI'] )) {
			echo $this->pagination->getPagesLinks();
		}
	?>
</div>
