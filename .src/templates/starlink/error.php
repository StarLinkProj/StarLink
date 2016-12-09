<?php defined( '_JEXEC' ) or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$tpath = $this->baseurl.'/templates/'.$this->template;

$this->setGenerator(null);
$assetsPathFile = JPATH_ROOT.'/media/mod_starlink';
$assetsPath = $this->baseurl.'/media/mod_starlink';
$doc->addStyleSheet($assetsPath . '/css/bootstrap.min.css');
$doc->addStyleSheet($assetsPath . '/css/common.css');
$doc->addStyleSheet($assetsPath . '/css/font-default.css');
$doc->addStyleSheet($assetsPath . '/css/menu.css');
$doc->addStyleSheet($assetsPath . '/css/footer.css');
?><!doctype html>

<html lang="<?php echo $this->language; ?>">

<head>
  <title><?php echo $this->title; ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /> <!-- mobile viewport optimized -->
</head>

<body>
  <?php include_once($assetsPathFile . '/images/icons.svg'); ?>
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
          <!-- TODO  change phone number and logo for parameters of template  -->
          <jdoc:include type="modules" name="s-00-topPhone"/>
        </div>
      </div>
      <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0 col-lg-5 mainMenuDiv">
        <nav class="navbar navbar-default">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#mainCollapse" aria-expanded="false">
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
  </header>

  <div class="container containerError">
<!--    <header class="row">
      <div class="four columns">
        <a href="<?php /*echo $this->baseurl; */?>/">
          <img class="u-max-full-width" src="/images/main/logo-lowres.png" alt="starlink logo" width="150">
        </a>
      </div>
      <div class="eight columns">
        <h1 class="col">Здесь пусто</h1>
      </div>
    </header>-->

	  <section id="error" class="col-xs-8 col-xs-offset-2">
	    <?php 
          echo '<h2>'.$this->error->getCode().' - '.$this->error->getMessage().'</h2>';
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
	  </section>
  </div>

  <div class="pre-footer"></div>
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-xs-12 copyright">
          &copy; 2016 &nbsp; <a class="footer__link" href="<?php echo JURI::base(); ?>">Старлинк</a>
        </div>
        <div class="col-md-6 col-xs-12">
          <jdoc:include type="modules" name="s-03-footerMenu" />
        </div>
        <div class="col-md-3 col-xs-12">
          <div class="footer__socialBlock">
            <a class="footer__link footer__icon" href="https://www.facebook.com/StarlinkUA/" target="_blank">
              <svg version="1.1"
                   class="footer__svg footer__svg_facebook"
                   baseProfile="full"
                   height="100" width="100"
                   fill="#3b5998"
                   viewBox="0 0 198 384.533"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M198,64.533c-75.981-3.327-70.282,3.784-69,76c22.331,0.333,44.669,0.667,67,1c-3,22.331-6,44.669-9,67 c-19.331,0-38.669,0-58,0c0,58.661,0,117.339,0,176c-23.664,0-47.336,0-71,0c0.333-58.327,0.667-116.672,1-175c-0.333-0.333-0.667-0.667-1-1c19.331,0-38.669,0-58,0c0-22.664,0-45.336,0-68c19.665,0,39.335,0,59,0c0-16.998,0-34.002,0-51 c0.171-70.276,43.131-100.464,139-86C198,23.865,198,44.202,198,64.533z"/>
              </svg>
            </a>
            <a class="footer__link footer__icon" href="https://twitter.com/StarlinkUa/" target="_blank">
              <svg version="1.1"
                   class="footer__svg footer__svg_twitter"
                   baseProfile="full"
                   fill="#00aced"
                   height="100" width="100"
                   viewBox="702 1232.89 100 100"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M802,1252.734c-3.679,1.632-7.633,2.734-11.783,3.23c4.235-2.539,7.489-6.559,9.021-11.35	c-3.964,2.351-8.355,4.058-13.029,4.979c-3.742-3.988-9.074-6.479-14.975-6.479c-11.33,0-20.516,9.185-20.516,20.516	c0,1.608,0.181,3.174,0.531,4.675c-17.051-0.855-32.168-9.023-42.287-21.436c-1.766,3.03-2.778,6.554-2.778,10.314	c0,7.118,3.622,13.397,9.127,17.077c-3.363-0.107-6.527-1.03-9.293-2.566c-0.002,0.086-0.002,0.171-0.002,0.258	c0,9.94,7.072,18.232,16.457,20.117c-1.721,0.469-3.534,0.72-5.405,0.72c-1.322,0-2.607-0.129-3.86-0.368	c2.611,8.15,10.188,14.082,19.165,14.247c-7.021,5.503-15.868,8.783-25.48,8.783c-1.656,0-3.289-0.097-4.894-0.287	c9.079,5.821,19.864,9.218,31.449,9.218c37.737,0,58.373-31.262,58.373-58.373c0-0.89-0.021-1.774-0.06-2.654 	C795.771,1260.462,799.25,1256.849,802,1252.734"/>
              </svg>
            </a>
            <a class="footer__link footer__icon" href="https://plus.google.com/u/1/b/107580631455821459922/107580631455821459922?hl=uk" target="_blank">
              <svg version="1.1"
                   class="footer__svg footer__svg_googlePlus"
                   baseProfile="full"
                   height="63.5" width="100"
                   fill="#DD4B39"
                   viewBox="-247 470.9 100 63.5"
                   xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path d="M-215.2,498.1c0,3.6,0,7.2,0,10.8c6.1,0.2,12.1,0.1,18.2,0.2c-2.7,13.4-20.9,17.8-30.6,9		c-9.9-7.7-9.5-24.6,0.9-31.7c7.2-5.8,17.5-4.3,24.7,0.7c2.8-2.6,5.5-5.4,8.1-8.3c-6-4.8-13.4-8.2-21.2-7.8		c-16.4-0.5-31.4,13.8-31.7,30.1c-1,13.4,7.7,26.5,20.2,31.2c12.4,4.8,28.2,1.5,36.1-9.6c5.2-7,6.3-16.1,5.7-24.6		C-195,498.1-205.1,498.1-215.2,498.1z"/>
                  <path d="M-156.1,498.1c0-3,0-6.1-0.1-9.1c-3,0-6,0-9,0c0,3-0.1,6-0.1,9.1c-3,0-6.1,0-9.1,0.1c0,3,0,6,0,9		c3,0,6.1,0.1,9.1,0.1c0,3,0,6,0.1,9.1c3,0,6,0,9,0c0-3,0-6,0.1-9.1c3,0,6.1,0,9.1-0.1c0-3,0-6,0-9		C-150,498.1-153.1,498.1-156.1,498.1z"/>
                </g>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>

</html>
