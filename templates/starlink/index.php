<?php
  defined( '_JEXEC' ) or die;
  require_once JPATH_THEMES.'/'.$this->template.'/logic.php';
?>
<!doctype html>
<html lang="<?php echo $this->language; ?>">
<!-- template:<?php echo $this->template; ?> -->
<!--   itemId:<?php echo $itemId; ?>         -->
<head>
  <!-- TODO remove redundand & debug css/js in production:
       TODO replace with minified files the rest -->
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WXQGPR');</script>
  <!-- End Google Tag Manager -->
  <!-- head -->
  <jdoc:include type="head" />
  <!-- /head -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WXQGPR"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
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
  <div class="container-fluid aboutCompany">
    <div class="container">
      <jdoc:include type="modules" name="s-04-aboutCompany" />
    </div>
  </div>

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
/*    Not Menu Home, IT-консалтинг, IT-интеграция, Дата-центр, Безопасность, Web-проекты, Блог, Вакансии, Совместная работа сотрудников на базе продуктов Kerio,
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
    124 conferencing-kerio-operator

    то есть
    106 IT-outsourcing
    111 О компании
    112 Услуги,
    113 Решения,
    115 Контакты,
    117 Кто мы?,
    119 Портфолио,
    134 Виртуализация,
    135 Хостинг / Колокейшн,
    136 Аренда серверов и ПО (SaaS),
    137 SSL-сертификаты,
    138 аналы связи,
 */
    ?>
    <?php if (!in_array($itemId, [101, 114, 105, 107, 108, 109, 110, 118, 120, 121, 122, 123, 124])) : ?>
      <div class="container article">
        <jdoc:include type="component" />
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
      <!--begin jdoc:include type="modules" name="s-19-vacancies"-->
      <jdoc:include type="modules" name="s-19-vacancies" />
      <!--end   jdoc:include type="modules" name="s-19-vacancies" -->
    </div>

  <!-- customModule with Component inside -->
  <div class="container-fluid">
    <!--begin jdoc:include type="modules" name="customModule"-->
    <jdoc:include type="modules" name="customModule" />
    <!--end   jdoc:include type="modules" name="customModule" -->
  </div>

  <!-- begin jdoc:include type="modules" name="s-08-services" style="services" -->
  <jdoc:include type="modules" name="s-08-services" style="services" />
  <!-- end   jdoc:include type="modules" name="s-08-services" style="services" -->

  <div class="container-fluid notReadyToCall">
    <div class="container">
      <div class="row">
        <jdoc:include type="modules" name="s-10-notReadyToCall" style="xhtml" />
      </div>
    </div>
  </div>

  <div class="container-fluid profitable-it-outsourcing">
    <div class="container">
      <div class="row">
        <jdoc:include type="modules" name="s-11-profitableItOutsourcing" style="xhtml" />
      </div>
    </div>
  </div>


  <jdoc:include type="modules" name="itOutsourcingCalculator" style="xhtml" />

  <!-- begin doc:include type="modules" name="s-12-googleMap" style="none" -->
  <jdoc:include type="modules" name="s-12-googleMap" style="none" />
  <!-- end   doc:include type="modules" name="s-12-googleMap" style="none" -->

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
