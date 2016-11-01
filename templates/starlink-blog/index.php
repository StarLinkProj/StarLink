<?php
  defined( '_JEXEC' ) or die;
  require_once JPATH_THEMES.'/'.$this->template.'/logic.php';
?>
<!doctype html>
<html lang="<?php echo $this->language; ?>">
<!-- starlink-blog template -->
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <!-- head -->
  <jdoc:include type="head" />
  <!-- /head -->
</head>
<body>
<?php echo '<!-- itemId=' . $itemId . '-->'; ?>
<header class="container-fluid">
  <div class="b-topRow row">
    <div class="col-xs-12 col-sm-8 col-md-3 col-lg-4">
      <a title="StarLink" href="<?php echo JURI::base(); ?>">
        <div class="b-logo">
          <img class="b-logo__image" src="/images/main/logo-vector.svg">
        </div>
      </a>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="b-phone">
        <!-- TODO  change phone number and logo for parameters of tempalte  -->
        <jdoc:include type="modules" name="s-00-topPhone"/>
      </div>
    </div>
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0 col-lg-5 mainMenuDiv">
      <nav class="navbar navbar-default">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainCollapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="mainCollapse">
          <jdoc:include type="modules" name="s-01-mainMenu" />
          <a href="javascript:void(0)" class="searchButton">
            <img src="/images/main/search_icon.png">
          </a>
        </div>
      </nav>
    </div>
    <div class="hidden-xs hidden-sm col-md-6 col-lg-5 searchLineDiv">
      <jdoc:include type="modules" name="search" />
    </div>
  </div>
</header>

<!-- begin Menu page Blog -->
<div class="container-fluid mainBlog">
  <div class="container">
    <div class="row">
      <h1 class="col-xs-12 col-md-9 mainBlog__header">Блог</h1>
      <div class="clearfix"></div>
      <div class="col-xs-12 col-md-9">
        <jdoc:include type="component" />
      </div>
      <div class="hidden-xs hidden-sm col-md-3 panelBlog">
        <jdoc:include type="modules" name="s-18-rightSideMenu" />
      </div>
    </div>
  </div>
</div>

<!-- Blog's blue box -->
<div class="container-fluid">
  <!--begin jdoc:include type="modules" name="customModule"-->
  <jdoc:include type="modules" name="s-19-blueBlog" />
  <!--end   jdoc:include type="modules" name="customModule" -->
</div>

<div class="pre-footer"></div>

<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-xs-12 copyright">
        &copy; 2016 &nbsp; <a href="<?php echo JURI::base(); ?>">Старлинк</a>
      </div>
      <div class="col-md-6 col-xs-12">
        <jdoc:include type="modules" name="s-03-footerMenu" />
      </div>
      <div class="col-md-3 col-xs-12">
        <jdoc:include type="modules" name="s-04-footerSocNetworks" />
      </div>
    </div>
  </div>
</footer>

</body>
</html>














