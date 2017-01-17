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

<?= '<!-- BEGIN starlink template override of mod_djimageslider/starlink.php -->' ?>
<div style="position:relative; <?php /*top: -1px; */ ?> z-index: 0; border: 0px !important;">

  <section id="djslider-loader<?=$mid?>" class="djslider-loader djslider-loader-<?=$theme?>" data-animation='<?=$animationOptions?>' data-djslider='<?=$moduleSettings?>'<?=$wcag?>>

    <div id="djslider<?=$mid?>" class="djslider djslider-<?=$theme?><?=$params->get('image_centering', 0) ? ' img-vcenter':''?>" style="<?=$style['slider']?>">
      <div id="slider-container<?=$mid?>" class="djslider__container slider-container">
        <ul id="slider<?=$mid?>" class="djslider__in djslider-in">

            <?php foreach ($slides as $slide) {

              $rel = (!empty($slide->rel) ? 'rel="'.$slide->rel.'"':''); ?>

              <li style="<?=$style['slide']?>" class="djslider__listItem">

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
                    <a <?= $attr ?> href="<?= ($action > 1 ? $slide->image : $slide->link) ?>" target="<?= $slide->target ?>">
                  <?php } ?>
                  <img class="djslider__image dj-image" src="<?= $slide->image ?>" alt="<?= $slide->alt ?>" style="<?= $style['image'] ?>"/>
                  <?php if (($slide->link && $action==1) || $action>1) { ?>
                    </a>
                  <?php }
                }

                if($params->get('slider_source') && ($params->get('show_title') || ($params->get('show_desc') && !empty($slide->description) || ($params->get('show_readmore') && $slide->link)))) { ?>
                  <!-- Slide description area: START -->
                  <div class="djslider__desc slide-desc" style="" style_original="padding: 0 90px; margin: auto; top: 20%; left: 0; right: 0;">

                    <div class="djslider__desc-in slide-desc-in">
                      <div class="djslider__desc-bg slide-desc-bg slide-desc-bg-<?= $theme ?>"></div>
                      <div class="djslider__desc-text slide-desc-text slide-desc-text-<?= $theme ?>">

                        <?php if($params->get('show_title')) { ?>
                          <div class="djslider__title slide-title">
                            <?php if($params->get('link_title') && $slide->link) { ?>
                              <a class="djslider__title-link" href="<?= $slide->link ?>" target="<?= $slide->target ?>" <?= $rel; ?>>
                            <?php }
                            echo $slide->title;
                            if($params->get('link_title') && $slide->link) { ?>
                              </a>
                            <?php } ?>
                          </div>
                        <?php }

                        if($params->get('show_desc')) { ?>
                          <div class="djslider__text slide-text">
                            <?php if($params->get('link_desc') && $slide->link) { ?>
                            <a href="<?= $slide->link ?>" target="<?= $slide->target ?>" <?= $rel ?>>
                              <?= strip_tags($slide->description,"<br><span><em><i><b><strong><small><big>") ?>
                            </a>
                            <?php } else {
                              echo $slide->description;
                            } ?>
                          </div>
                        <?php }

                        if($params->get('show_readmore') && $slide->link) { ?>
                          <a href="<?= $slide->link ?>" target="<?= $slide->target ?>" <?= $rel ?> class="djslider__readmore readmore">
                            <?= ($params->get('readmore_text',0) ? $params->get('readmore_text') : JText::_('MOD_DJIMAGESLIDER_READMORE')) ?>
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
        <div id="navigation<?= $mid ?>" class="djslider__nav" class_original="navigation-container container" style_original="top:48%; margin: 0 auto;">
          <?php if($show->arr) { ?>
          <img id="prev<?= $mid ?>" class="prev-button <?= $show->arr==1 ? 'showOnHover':'' ?>"
               src="<?= $navigation->prev ?>"
               alt="<?= $direction == 'rtl' ? JText::_('MOD_DJIMAGESLIDER_NEXT') : JText::_('MOD_DJIMAGESLIDER_PREVIOUS') ?>"<?= $wcag ?> />
          <img id="next<?= $mid ?>" class="next-button <?= $show->arr==1 ? 'showOnHover':'' ?>"
               src="<?= $navigation->next ?>"
               alt="<?= $direction == 'rtl' ? JText::_('MOD_DJIMAGESLIDER_PREVIOUS') : JText::_('MOD_DJIMAGESLIDER_NEXT') ?>"<?= $wcag; ?> />
          <?php }
          if($show->btn) { ?>
            <img id="play<?= $mid ?>" class="play-button <?= $show->btn==1 ? 'showOnHover':'' ?>"
                 src="<?= $navigation->play ?>" alt="<?= JText::_('MOD_DJIMAGESLIDER_PLAY') ?>"<?= $wcag ?> />
            <img id="pause<?= $mid ?>" class="pause-button <?= $show->btn==1 ? 'showOnHover':'' ?>"
                 src="<?= $navigation->pause ?>" alt="<?= JText::_('MOD_DJIMAGESLIDER_PAUSE') ?>"<?= $wcag ?> />
          <?php } ?>
        </div>
      <?php }

      if($show->idx) { ?>
        <div id="cust-navigation<?= $mid ?>"
             class="<?= $params->get('idx_style', 0) ? 'djslider__nav-numbers navigation-numbers' : 'djslider__nav-numbers navigation-container-custom' ?> <?= $show->idx==2 ? 'showOnHover':'' ?>">
          <?php $i = 0;
          foreach ($slides as $slide) { ?>
            <span class="load-button<?php if ($i == 0) echo ' load-button-active'; ?>"<?= $wcag ?>>
              <?php if($params->get('idx_style')) echo ($i+1) ?>
            </span>
            <?php $i++;
          } ?>
      </div>
      <?php } ?>

    </div>

  </section>

</div>

<div class="djslider-end" style="clear: both"<?= $wcag ?>></div>
<?= '<!-- END starlink template override of mod_djimageslider/starlink.php -->' ?>