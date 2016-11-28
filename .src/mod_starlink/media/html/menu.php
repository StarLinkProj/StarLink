
<div class="b-topRow row">
    <div class="col-xs-12 col-sm-8 col-md-3 col-lg-4">
      <a title="StarLink" href="<?php echo JURI::base(); ?>">
        <div class="b-logo">
          <img class="b-logo__image" src="<?=$assetsPath?>/images/logo-vector.svg">
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
      <jdoc:include type="modules" name="s-02-search" />
    </div>
  </div>
