
<div class="span12">
  <div class="item column-1">

<!--    <?php /*if ( json_decode($item->images)->image_intro ) { */?>
      <div class="pull-none item-image">
        <a href="<?php /*echo $item->link; */?>"><img class="img-responsive" src="/<?php /*echo json_decode($item->images)->image_intro; */?>" alt=""></a>
      </div>
    --><?php /*} */?>

    <div class="page-header">
      <h2 itemprop="name">
        <a href="<?=$item->link?>" itemprop="url"><?=$item->title?></a>
      </h2>
    </div>

    <div class="newsCatAndDate"><?php echo $item->category_title; ?> | <?php echo date("d.m.Y", strtotime($item->created)); ?></div>

    <?php echo $item->introtext; ?>

    <div class="newsCategoryItemFooter row">
      <div class="newsHits col-sm-6 col-xs-7"><?php echo $item->hits; ?></div>
      <div class="newsReadMore col-sm-6 col-xs-5">
        <p class="readmore">
          <a class="btn" href="<?=$item->link?>" itemprop="url"></a>
        </p>
      </div>
    </div>
  </div>
</div>