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

<?= '<!-- BEGIN starlink template override of mod_djimageslider/simpleflex.php -->' ?>

<section id="slider-loader<?=$mid?>" class="djslider__loader djslider__loader--<?=$theme?>" data-animation='<?=$animationOptions?>' data-djslider='<?=$moduleSettings?>'<?=$wcag?> style="position:relative;">

  <div id="slider<?=$mid?>" class="djslider djslider--<?=$theme?>" style="<?=$style['slider']?>">
    <div id="slider-container<?=$mid?>" class="djslider__container djslider__container--<?=$theme?>">
      <ul id="slider-in<?=$mid?>" class="djslider__in djslider__in--<?=$theme?>">

          <?php foreach ($slides as $slide) {

            $rel = (!empty($slide->rel) ? 'rel="'.$slide->rel.'"':''); ?>

            <li style="<?=$style['slide']?>" class="djslider__listItem djslider__listItem--<?=$theme?>">

              <?php if($slide->image) {
                $action = $params->get('link_image',1);

                if ($action > 1) {
                  $desc = $params->get('show_desc') ? 'title="' . (!empty($slide->title) ? htmlspecialchars($slide->title . ' ') : '') . (!empty($slide->description) ? htmlspecialchars('<small>' . strip_tags($slide->description, "<p><a><b><strong><em><i><u>") . '</small>') : '') . '"' : '';
                  if ($jquery){
                    $attr = 'class="image-link" data-' . $desc;
                  } else {
                    $attr = 'rel="lightbox-slider' . $mid . '" ' . $desc;
                  }
                } else {
                  $attr = $rel;
                }

                if (($slide->link && $action == 1) || $action > 1) { ?>
                  <a <?=$attr?> href="<?=($action > 1 ? $slide->image : $slide->link)?>" target="<?=$slide->target?>">
                <?php } ?>
                <img class="djslider__image djslider__image--<?=$theme?>" src="<?=$slide->image?>" alt="<?=$slide->alt?>" style="<?=$style['image']?>"/>
                <?php if (($slide->link && $action==1) || $action>1) { ?>
                  </a>
                <?php }
              }

              if($params->get('slider_source') && ($params->get('show_title') || ($params->get('show_desc') && !empty($slide->description) || ($params->get('show_readmore') && $slide->link)))) { ?>
                <!-- Slide description area: START -->
                <div class="djslider__desc djslider__desc--<?=$theme?>" style="">

                  <div class="djslider__desc__in djslider__desc__in--<?=$theme?>">
                    <div class="djslider__desc__bg djslider__desc__bg--<?=$theme?>"></div>
                    <div class="djslider__desc__text djslider__desc__text--<?=$theme?>">

                      <?php if($params->get('show_title')) { ?>
                        <div class="djslider__title">
                          <?php if($params->get('link_title') && $slide->link) { ?>
                            <a class="djslider__title__link djslider__title__link--<?=$theme?>" href="<?=$slide->link?>" target="<?=$slide->target?>" <?=$rel?>>
                          <?php }
                          echo $slide->title;
                          if($params->get('link_title') && $slide->link) { ?>
                            </a>
                          <?php } ?>
                        </div>
                      <?php }

                      if($params->get('show_desc')) { ?>
                        <div class="djslider__text jslider__text--<?=$theme?>">
                          <?php if($params->get('link_desc') && $slide->link) { ?>
                          <a href="<?=$slide->link?>" target="<?=$slide->target?>" <?=$rel?>>
                            <?=strip_tags($slide->description,"<br><span><em><i><b><strong><small><big>")?>
                          </a>
                          <?php } else {
                            echo $slide->description;
                          } ?>
                        </div>
                      <?php }

                      if($params->get('show_readmore') && $slide->link) { ?>
                        <a href="<?=$slide->link?>" target="<?=$slide->target?>" <?=$rel?> class="djslider__readmore djslider__readmore--<?=$theme?>">
                          <?=($params->get('readmore_text',0) ? $params->get('readmore_text') : JText::_('MOD_DJIMAGESLIDER_READMORE'))?>
                        </a>
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
      <div id="navigation<?=$mid?>" class="djslider__nav djslider__nav--<?=$theme?>">
        <?php if($show->arr) { ?>
        <img id="prev<?=$mid?>" class="prev-button <?=$show->arr==1 ? 'showOnHover':'' ?>"
             src="<?=$navigation->prev?>"
             alt="<?=$direction == 'rtl' ? JText::_('MOD_DJIMAGESLIDER_NEXT') : JText::_('MOD_DJIMAGESLIDER_PREVIOUS')?>"<?=$wcag?> />
        <img id="next<?=$mid?>" class="next-button <?=$show->arr==1 ? 'showOnHover':''?>"
             src="<?=$navigation->next?>"
             alt="<?=$direction == 'rtl' ? JText::_('MOD_DJIMAGESLIDER_PREVIOUS') : JText::_('MOD_DJIMAGESLIDER_NEXT')?>"<?=$wcag?> />
        <?php }
        if($show->btn) { ?>
          <img id="play<?=$mid?>" class="play-button <?=$show->btn==1 ? 'showOnHover':''?>"
               src="<?=$navigation->play?>" alt="<?=JText::_('MOD_DJIMAGESLIDER_PLAY')?>"<?=$wcag?> />
          <img id="pause<?=$mid?>" class="pause-button <?=$show->btn==1 ? 'showOnHover':''?>"
               src="<?=$navigation->pause?>" alt="<?=JText::_('MOD_DJIMAGESLIDER_PAUSE')?>"<?=$wcag?> />
        <?php } ?>
      </div>
    <?php }

    if($show->idx) { ?>
      <div id="cust-navigation<?=$mid?>"
           class="<?=$params->get('idx_style', 0) ? 'djslider__nav--numbers' : 'djslider__nav--numbers cust-navigation-container'?> <?=$show->idx==2 ? 'showOnHover':''?>">
        <?php $i = 0;
        foreach ($slides as $slide) { ?>
          <span class="load-button<?php if ($i == 0) echo ' load-button-active';?>"<?=$wcag?>>
            <?php if($params->get('idx_style')) echo ($i+1) ?>
          </span>
          <?php $i++;
        } ?>
    </div>
    <?php } ?>

  </div>

</section>

<div class="djslider-end" style="clear: both"<?=$wcag?>></div>
<?= '<!-- END starlink template override of mod_djimageslider/simpleflex.php -->' ?>