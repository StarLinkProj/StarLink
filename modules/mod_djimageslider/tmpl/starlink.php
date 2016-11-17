<?php
/* mao:  PLACE this in /modules/mod_djimageslider/tmpl folder  */
/**
 * @version $Id: default.php 33 2016-06-28 15:10:53Z szymon $
 * @package DJ-ImageSlider
 * @subpackage DJ-ImageSlider Component
 * @copyright Copyright (C) 2012 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 *
 *
 * DJ-ImageSlider is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-ImageSlider is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-ImageSlider. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// no direct access
defined('_JEXEC') or die ('Restricted access'); 

$wcag = $params->get('wcag', 1) ? ' tabindex="0"' : ''; ?>

<div style_original="border: 0px !important;">
<section id="djslider-loader<?php echo $mid; ?>" class="djslider-loader djslider-loader-<?php echo $theme ?>" data-animation='<?php echo $animationOptions ?>' data-djslider='<?php echo $moduleSettings ?>'<?php echo $wcag; ?>>
    <div id="djslider<?php echo $mid; ?>" class="djslider djslider-<?php echo $theme; echo $params->get('image_centering', 0) ? ' img-vcenter':'' ?>" style="<?php echo $style['slider'] ?>">
        <div id="slider-container<?php echo $mid; ?>" class="djslider__container slider-container">
        	<ul id="slider<?php echo $mid; ?>" class="djslider__in djslider-in">
          		<?php foreach ($slides as $slide) { 
          			$rel = (!empty($slide->rel) ? 'rel="'.$slide->rel.'"':''); ?>
          			<li style="<?php echo $style['slide'] ?>" class="djslider__listItem">
          				<?php if($slide->image) { 
          					$action = $params->get('link_image',1);
          					if($action > 1) {
								$desc = $params->get('show_desc') ? 'title="'.(!empty($slide->title) ? htmlspecialchars($slide->title.' ') : '').(!empty($slide->description) ? htmlspecialchars('<small>'.strip_tags($slide->description,"<p><a><b><strong><em><i><u>").'</small>') : '').'"':'';
	          					if($jquery) {
	          						$attr = 'class="image-link" data-'.$desc;
	          						
	          					} else {
	          						$attr = 'rel="lightbox-slider'.$mid.'" '.$desc;
	          					}
							} else {
								$attr = $rel;
							}
          					?>
	            			<?php if (($slide->link && $action==1) || $action>1) { ?>
								<a <?php echo $attr; ?> href="<?php echo ($action>1 ? $slide->image : $slide->link); ?>" target="<?php echo $slide->target; ?>">
							<?php } ?>
								<img class="djslider__image dj-image" src="<?php echo $slide->image; ?>" alt="<?php echo $slide->alt; ?>" style="<?php echo $style['image'] ?>"/>
							<?php if (($slide->link && $action==1) || $action>1) { ?>
								</a>
							<?php } ?>
						<?php } ?>
						<?php if($params->get('slider_source') && ($params->get('show_title') || ($params->get('show_desc') && !empty($slide->description) || ($params->get('show_readmore') && $slide->link)))) { ?>
						<!-- Slide description area: START -->
						<div class="djslider__desc slide-desc" style="" style_original="padding: 0 90px; margin: auto; top: 20%; left: 0; right: 0;">
						  <div class="djslider__desc-in slide-desc-in">
							<div class="djslider__desc-bg slide-desc-bg slide-desc-bg-<?php echo $theme ?>"></div>
							<div class="djslider__desc-text slide-desc-text slide-desc-text-<?php echo $theme ?>">
							<?php if($params->get('show_title')) { ?>
								<div class="djslider__title slide-title">
									<?php if($params->get('link_title') && $slide->link) { ?><a class="djslider__title-link" href="<?php echo $slide->link; ?>" target="<?php echo $slide->target; ?>" <?php echo $rel; ?>><?php } ?>
										<?php echo $slide->title; ?>
									<?php if($params->get('link_title') && $slide->link) { ?></a><?php } ?>
								</div>
							<?php } ?>
							
							<?php if($params->get('show_desc')) { ?>
								<div class="djslider__text slide-text">
									<?php if($params->get('link_desc') && $slide->link) { ?>
									<a href="<?php echo $slide->link; ?>" target="<?php echo $slide->target; ?>" <?php echo $rel; ?>>
										<?php echo strip_tags($slide->description,"<br><span><em><i><b><strong><small><big>"); ?>
									</a>
									<?php } else { ?>
										<?php echo $slide->description; ?>
									<?php } ?>
								</div>
							<?php } ?>
							
							<?php if($params->get('show_readmore') && $slide->link) { ?>
								<a href="<?php echo $slide->link; ?>" target="<?php echo $slide->target; ?>" <?php echo $rel; ?> class="djslider__readmore readmore"><?php echo ($params->get('readmore_text',0) ? $params->get('readmore_text') : JText::_('MOD_DJIMAGESLIDER_READMORE')); ?></a>
							<?php } ?>
							<div style="clear: both"></div>
							</div>
						  </div>
						</div>
						<!-- Slide description area: END -->
						<?php } ?>						
						
					</li>
                <?php } ?>
        	</ul>
        </div>
        <?php if($show->arr || $show->btn) { ?>
        <div id="navigation<?php echo $mid; ?>" class="djslider__nav" class_original="navigation-container container" style_original="top:48%; margin: 0 auto;">
        	<?php if($show->arr) { ?>
        	<img id="prev<?php echo $mid; ?>" class="prev-button <?php echo $show->arr==1 ? 'showOnHover':'' ?>" src="<?php echo $navigation->prev; ?>" alt="<?php echo $direction == 'rtl' ? JText::_('MOD_DJIMAGESLIDER_NEXT') : JText::_('MOD_DJIMAGESLIDER_PREVIOUS'); ?>"<?php echo $wcag; ?> />
			<img id="next<?php echo $mid; ?>" class="next-button <?php echo $show->arr==1 ? 'showOnHover':'' ?>" src="<?php echo $navigation->next; ?>" alt="<?php echo $direction == 'rtl' ? JText::_('MOD_DJIMAGESLIDER_PREVIOUS') : JText::_('MOD_DJIMAGESLIDER_NEXT'); ?>"<?php echo $wcag; ?> />
			<?php } ?>
			<?php if($show->btn) { ?>
			<img id="play<?php echo $mid; ?>" class="play-button <?php echo $show->btn==1 ? 'showOnHover':'' ?>" src="<?php echo $navigation->play; ?>" alt="<?php echo JText::_('MOD_DJIMAGESLIDER_PLAY'); ?>"<?php echo $wcag; ?> />
			<img id="pause<?php echo $mid; ?>" class="pause-button <?php echo $show->btn==1 ? 'showOnHover':'' ?>" src="<?php echo $navigation->pause; ?>" alt="<?php echo JText::_('MOD_DJIMAGESLIDER_PAUSE'); ?>"<?php echo $wcag; ?> />
			<?php } ?>
        </div>
        <?php } ?>
        <?php if($show->idx) { ?>
		<div id="cust-navigation<?php echo $mid; ?>" class="<?php echo $params->get('idx_style', 0) ? 'djslider__nav-numbers navigation-numbers' : 'djslider__nav-numbers navigation-container-custom' ?> <?php echo $show->idx==2 ? 'showOnHover':'' ?>">
			<?php $i = 0; foreach ($slides as $slide) { 
				?><span class="load-button<?php if ($i == 0) echo ' load-button-active'; ?>"<?php echo $wcag; ?>><?php if($params->get('idx_style')) echo ($i+1) ?></span><?php 
			$i++; } ?>
        </div>
        <?php } ?>
    </div>
</section>
</div>
<div class="djslider-end" style="clear: both"<?php echo $wcag; ?>></div>