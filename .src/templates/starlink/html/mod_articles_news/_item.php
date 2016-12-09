<!--    <?php /*if ( json_decode($item->images)->image_intro ) { */?>
    <div class="pull-none item-image">
      <a href="<?php /*echo $item->link; */?>"><img class="img-responsive" src="/<?php /*echo json_decode($item->images)->image_intro; */?>" alt=""></a>
    </div>
  --><?php /*} */?>

<?php
defined('_JEXEC') or die;

?>

<div class="article--box">
    <div class="imageFill">
      <img class="imageFill__image" src="https://placehold.it/330x90/B0E5F7/B0E5F7">
    </div>

      <h3 class="article__title" itemprop="name">
        <a class="article__link" href="<?=$item->link?>" itemprop="url"><?=$item->title?></a>
      </h3>

    <div class="article__metadata newsCatAndDate"><?php echo $item->category_title; ?> | <?php echo date("d.m.Y", strtotime($item->created)); ?></div>

    <?php echo $item->introtext; ?>

    <div class="article__footer article__footer--newsflash row">
      <div class="article__hits col-sm-6 col-xs-7"><?php echo $item->hits; ?></div>
      <div class="article__readMore col-sm-6 col-xs-5">
        <p class="article__readMoreText article__readMoreText--newsflash">
          <a class="article__btn btn" href="<?=$item->link?>" itemprop="url"></a>
        </p>
      </div>
    </div>
</div>

