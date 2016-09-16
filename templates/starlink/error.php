<?php defined( '_JEXEC' ) or die;

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$tpath = $this->baseurl.'/templates/'.$this->template;

?><!doctype html>

<html lang="<?php echo $this->language; ?>">

<head>
  <title><?php echo $this->title; ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /> <!-- mobile viewport optimized -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300&subset=cyrillic" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $tpath; ?>/css/normalize.css">
  <link rel="stylesheet" href="<?php echo $tpath; ?>/css/am_skeleton.css">
  <link rel="stylesheet" href="<?php echo $tpath; ?>/css/error.css?v=1">
</head>

<body>
  <div class="container containerError">
	<header class="row">
      <div class="four columns">
	    <a href="<?php echo $this->baseurl; ?>/">
	      <img class="u-max-full-width" src="/images/main/logo.png" alt="starlink logo" width="150">
	    </a>
	  </div>
	  <div class="eight columns">
	    <h1 class="col">Здесь пусто</h1>
	  </div>
    </header>
	<section class="row">
	  <aside class="four columns">&nbsp;</aside>
	  <article id="error" class="eight columns">
	    <?php 
          echo '<h4>'.$this->error->getCode().' - '.$this->error->getMessage().'</h4>'; 
          if (($this->error->getCode()) == '404') {
            echo '<p>'.JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND').'</p>';
          }
	    ?>
        <p>
          <a href="<?php echo $this->baseurl; ?>/"><?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></a>
        </p>
        <?php // render module mod_search
          $module = new stdClass();
          $module->module = 'mod_search';
          echo JModuleHelper::renderModule($module);
        ?>
	  </article>
	</section>
	<section class="push"></section>
  </div>
  <footer>
    <div class="container">
      <div class="four columns">&nbsp;</div>
	  <div class="eight columns">
	    <a href="<?php echo $this->baseurl; ?>/"><p>© 2016   Старлинк</p></a>
	  </div>
	</div>
  </footer>
</html>
