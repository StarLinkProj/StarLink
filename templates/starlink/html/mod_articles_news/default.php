<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="newsflash<?php echo $moduleclass_sfx; ?>">
  <div class="container">
    <div class="row">
      <?php
        $i = 0;
        foreach ($list as $item) :
          if ( $i < count($list)-1 ) :  ?>
            <div class="items-row col-xs-12 col-sm-6 col-md-4 cols-1 row-0 row-fluid clearfix">
          <?php else : ?>
            <div class="items-row col-xs-12 col-sm-12 col-md-4 cols-1 row-0 row-fluid clearfix">
          <?php endif;
          require JModuleHelper::getLayoutPath('mod_articles_news', '_item');
          echo '</div>';
          $i++;
        endforeach;
      ?>
    </div>
  </div>
  <div class="showAllNews">
    <a href="/about/news">Смотреть остальные новости</a>
  </div>
</div>
