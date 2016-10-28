<?php
  defined( '_JEXEC' ) or die;
  require_once JPATH_THEMES.'/'.$this->template.'/logic.php';
?>
<!doctype html>
<html lang="<?php echo $this->language; ?>">

<head>
  <!-- TODO remove redundand & debug css/js in production:
       TODO remove /media/jui/js/jquery-migrate,
       TODO remove /media/jui/js/jquery-ui,
       TODO remove /media/jui/js/bootstrap.min.js etc
       TODO replace with minified files the rest -->

  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,300i,400,400i,500,700,900&subset=cyrillic" rel="stylesheet">
  <!-- head -->
  <jdoc:include type="head" />
  <!-- /head -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
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
          <jdoc:include type="modules" name="topPhone"/>
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
            <jdoc:include type="modules" name="mainMenu" />
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

	<!-- Menu О Компании -->
  <?php if ($itemId == 111) : ?>
    <div class="container-fluid aboutPageBl">
      <div class="container">
        <jdoc:include type="modules" name="aboutPageBl" />
      </div>
    </div>
  <?php endif; ?>
  <!-- /Menu О Компании -->

    <!-- begin jdoc:include type="modules" name="servicesTopBlWithBg"  -->
    <jdoc:include type="modules" name="servicesTopBlWithBg" />
    <!-- end   jdoc:include type="modules" name="servicesTopBlWithBg"  -->

    <!-- begin jdoc:include type="modules" name="itOutsourcingTopBlWithBg" style="xhtml" -->
    <jdoc:include type="modules" name="itOutsourcingTopBlWithBg" style="xhtml" />
    <!-- end   jdoc:include type="modules" name="itOutsourcingTopBlWithBg" style="xhtml" -->

    <!-- begin jdoc:include type="modules" name="itOutsourcingWeProposeYou" style="xhtml" -->
    <jdoc:include type="modules" name="itOutsourcingWeProposeYou" style="xhtml" />
    <!-- end   jdoc:include type="modules" name="itOutsourcingWeProposeYou" style="xhtml" -->

	  <?php
/*    Not Menu IT-консалтинг, IT-интеграция, Дата-центр, Безопасность, Web-проекты, Блог, Вакансии, Совместная работа сотрудников на базе продуктов Kerio,
		Безопасность и защита информации, Объединение распределенных офисов в единую сеть, 	IP-телефония и видеоконференции
		105 consulting
		107 integration
		108 datacenter
    109 security
    110 webprojects
    114 about/news
		118 blog
		120 job-positions
		121 collaboration-kerio-connect,
    122 dataprotection-kerio-control,
    123 distributedorganization-starlink,
    124 conferencing-kerio-operator, */
    ?>
    <?php if (!in_array($itemId, [101, 114, 105, 107, 108, 109, 110, 118, 120, 121, 122, 123, 124])) : ?>
      <div class="container contentBl">
        <jdoc:include type="component" />
      </div>
    <?php endif; ?>

    <?php # Styles for Menu page Blog ?>
    <?php if ($itemId == 118) : ?>
      <div class="container-fluid contentBlBlog">
        <div class="container">
          <div class="row">
            <h1 class="col-xs-12 col-md-9 blogHeader">Блог</h1>
            <div class="clearfix"></div>
            <div class="col-xs-12 col-md-9">
              <jdoc:include type="component" />
            </div>
            <div class="hidden-xs hidden-sm col-md-3 rightSideMenuBl">
              <jdoc:include type="modules" name="rightSideMenuBl" />
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- begin jdoc:include type="modules" name="lastNews" style="xhtml"  -->
    <jdoc:include type="modules" name="lastNews" style="xhtml" />
    <!-- end   jdoc:include type="modules" name="lastNews" style="xhtml"  -->

    <!-- begin jdoc:include type="modules" name="itOutsourcingCallInfoBl" style="xhtml"  -->
    <jdoc:include type="modules" name="itOutsourcingCallInfoBl" style="xhtml" />
    <!-- end   jdoc:include type="modules" name="itOutsourcingCallInfoBl" style="xhtml"  -->

    <div class="container-fluid mainSliderBlock">
      <jdoc:include type="modules" name="mainSlider" />
    </div>

    <!-- begin jdoc:include type="modules" name="partners" style="xhtml"-->
    <jdoc:include type="modules" name="partners" style="xhtml" />
    <!-- end   jdoc:include type="modules" name="partners" style="xhtml"  -->

    <div class="container-fluid vacationsBlock">
      <!--begin jdoc:include type="modules" name="customModule"-->
      <jdoc:include type="modules" name="customModule" />
      <!--end   jdoc:include type="modules" name="customModule" -->
    </div>

    <div class="container-fluid services-bl">
      <div class="container">
        <div class="row">
          <jdoc:include type="modules" name="services" style="xhtml" />
        </div>
      </div>
    </div>

    <div class="container-fluid no-ready-to-call-bl">
      <div class="container">
        <div class="row">
          <jdoc:include type="modules" name="notReadyToCall" style="xhtml" />
        </div>
      </div>
    </div>

    <?php #for Home page only  ?>
    <?php if ($itemId == 101) : ?>
      <div class="container-fluid profitable-it-outsourcing">
        <div class="container">
          <div class="row">
            <jdoc:include type="modules" name="profitableItOutsourcing" style="xhtml" />
          </div>
        </div>
      </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="itOutsourcingCalculator" style="xhtml" />

    <!-- for Home page, /contacts and /services/outsourcing -->
    <?php if (in_array($itemId, [101, 106, 115])) : ?>
      <div class="container-fluid">
        <div id="map">
        </div>
        <script>
          function initMap() {
            var mapDiv = document.getElementById('map');
            var map = new google.maps.Map(mapDiv, {
                center: {
                  lat: 50.4070134,
                  lng: 30.6364289
                },
                zoom: 16,
                scrollwheel: false
            });
            var marker = new google.maps.Marker({
                position: {lat: 50.4070134, lng: 30.6364289},
                map: map,
                title: 'StarLink'
            });
          }
        </script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcF4_JMyp4KWtLS_HwnKlAOw7Q9OCNleA&callback=initMap">
        </script>
      </div>
    <?php endif; ?>
    <!-- / for Home page, /contacts and /services/outsourcing -->

    <jdoc:include type="modules" name="reviews" style="xhtml" />

    <div class="pre-footer"></div>

    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-xs-12 copyright">
            &copy; 2016 &nbsp; <a href="<?php echo JURI::base(); ?>">Старлинк</a>
          </div>
          <div class="col-md-6 col-xs-12">
            <jdoc:include type="modules" name="footerMenu" />
          </div>
          <div class="col-md-3 col-xs-12">
            <jdoc:include type="modules" name="footerSocNetworks" />
          </div>
        </div>
      </div>
    </footer>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalContactFormBlock">
      <div class="modal-dialog modal-custom-form" role="document">
        <div class="modal-content">
          <button type="button" class="modalFormCloseBtn close" data-dismiss="modal">
          </button>
          <jdoc:include type="modules" name="modalContactForm" />
        </div>
      </div>
    </div>

</body>

</html>
