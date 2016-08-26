<?php if (preg_match('/services/', $_SERVER['REQUEST_URI'])) : ?>

	<div class="items-row col-md-4 col-sm-4 col-xs-12 cols-1 row-0 row-fluid clearfix">
		<div class="span12">
			<div class="item column-1">

				<div class="pull-none item-image">
					<a href="<?=$item->link?>"><img class="img-responsive imgMgAuto" src="/<?=json_decode($item->images)->image_intro?>" alt=""></a>
				</div>

				<div class="page-header">
					<h2 itemprop="name">
						<a href="<?=$item->link?>" itemprop="url"><?=$item->title?></a>
					</h2>
				</div>

				<div class="newsCatAndDate"><?php echo $item->category_title; ?> | <?php echo date("d.m.Y", strtotime($item->created)); ?></div>

				<?php echo $item->introtext; ?>

				<div class="newsCategoryItemFooter row">
					<div class="newsHits col-md-6 col-sm-6 col-xs-7"><?php echo $item->hits; ?></div>
					<div class="newsReadMore col-md-6 col-sm-6 col-xs-5">
						<p class="readmore">
							<a class="btn" href="<?=$item->link?>" itemprop="url"></a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php else : ?>
	<?php
	/**
	 * @package     Joomla.Site
	 * @subpackage  mod_articles_news
	 *
	 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
	 * @license     GNU General Public License version 2 or later; see LICENSE.txt
	 */

	defined('_JEXEC') or die;

	$item_heading = $params->get('item_heading', 'h4');
	?>
	<?php if ($params->get('item_title')) : ?>

		<<?php echo $item_heading; ?> class="newsflash-title<?php echo $params->get('moduleclass_sfx'); ?>">
		<?php if ($params->get('link_titles') && $item->link != '') : ?>
			<a href="<?php echo $item->link; ?>">
				<?php echo $item->title; ?>
			</a>
		<?php else : ?>
			<?php echo $item->title; ?>
		<?php endif; ?>
		</<?php echo $item_heading; ?>>

	<?php endif; ?>

	<?php if (!$params->get('intro_only')) : ?>
		<?php echo $item->afterDisplayTitle; ?>
	<?php endif; ?>

	<?php echo $item->beforeDisplayContent; ?>

	<?php echo $item->introtext; ?>

	<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) : ?>
		<?php echo '<a class="readmore" href="' . $item->link . '">' . $item->linkText . '</a>'; ?>
	<?php endif; ?>
<?php endif; ?>