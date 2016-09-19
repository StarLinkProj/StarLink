<?php defined( '_JEXEC' ) or die; 

include_once JPATH_THEMES.'/'.$this->template.'/logic.php';

?><!doctype html>

<?php
    require_once 'vendor/MobileDetect.php';
    $mobileDetectObj = new Mobile_Detect();
?>

<html lang="<?php echo $this->language; ?>">

<head>
    <link rel="stylesheet" href="/templates/starlink/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="/templates/starlink/css/calculator.css" type="text/css">
    <jdoc:include type="head" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <?php #if ($mobileDetectObj->isMobile() || $mobileDetectObj->isTablet()) : ?>
        <script src="/templates/starlink/js/libs/bootstrap.min.js" type="text/javascript"></script>
    <?php #endif; ?>
    <script src="/templates/starlink/js/libs/jquery-ui.js" type="text/javascript"></script>
    <script src="/templates/starlink/js/scripts.js" type="text/javascript"></script>
     <?php # if (preg_match('/services\/it-outsourcing/', $_SERVER['REQUEST_URI'])) : ?> 
        <script src="/templates/starlink/js/calculator_it_outsourcing.js" type="text/javascript"></script>
     <?php # endif; ?> 
    <script type="text/javascript">
        var myDomain = "http://<?php echo $_SERVER['HTTP_HOST'] ?>/"; 
    </script>
</head>
  
<body>
    <header class="container-fluid">
        <div class="row">
            <!-- < ? php #if ($mobileDetectObj->isMobile() || $mobileDetectObj->isTablet()) : ? > -->
                <!-- <div class="container-fluid"> -->
                <div class="visible-xs-block col-xs-12 topPhoneMobile">
                    <jdoc:include type="modules" name="topPhone" />
                </div>
<!--                </div>-->
<!--            < ? php #endif; ? >-->
            <div class="container">
                <div class="logo col-md-3 col-sm-6 col-xs-9">
                    <a title="StarLink" href="<?php echo JURI::base(); ?>">
					              <div id="logo-img"> </div>
                    </a>
                </div>

<!--                < ? php #if (!$mobileDetectObj->isMobile() && !$mobileDetectObj->isTablet()) : ? >-->
                    <div class="hidden-xs col-md-3 col-sm-6 topPhoneDiv">
                        <jdoc:include type="modules" name="topPhone" />
                    </div>
<!--                < ? php #endif; ? >-->

                <div class="col-md-6 col-xs-12 mainMenuDiv">
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
                            <jdoc:include type="modules" name="mainMenu" />
                            <a href="javascript:void(0)" class="searchButton"><img src="/images/main/search_icon.png"></a>
                        </div>
                    </nav>
                </div>
                <div class="hidden-xs hidden-sm col-md-9 searchLineDiv">
                    <jdoc:include type="modules" name="search" />
                </div>
            </div>
        </div>
    </header>

	<!-- Menu О Компании -->
    <?php if (preg_match("/about/", $_SERVER['REQUEST_URI'])) : ?>
        <div class="container-fluid aboutPageBl">
            <div class="container">
                <jdoc:include type="modules" name="aboutPageBl" />
            </div>
        </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="servicesTopBlWithBg" />

    <jdoc:include type="modules" name="itOutsourcingTopBlWithBg" style="xhtml" />

    <jdoc:include type="modules" name="itOutsourcingWeProposeYou" style="xhtml" />

    <?php $itemId = JRequest::getInt('Itemid'); ?>
	<!-- Not Menu IT-консалтинг, IT-интеграция, Дата-центр, Безопасность, Web-проекты, Блог, Вакансии, Совместная работа сотрудников на базе продуктов Kerio,
		Безопасность и защита информации, Объединение распределенных офисов в единую сеть, 	IP-телефония и видеоконференции  -->
    <?php if ($_SERVER['REQUEST_URI'] != '/' && !preg_match('/news/', $_SERVER['REQUEST_URI']) && !in_array($itemId, [105, 107, 108, 109, 110, 118, 120, 121, 122, 123, 124])) : ?>
        <div class="container contentBl">
            <jdoc:include type="component" />
        </div>
    <?php endif; ?>

    <!-- Styles for Menu page Blog -->
    <?php if ($itemId == 118) : ?>
        <?php if (preg_match('/blog/', $_SERVER['REQUEST_URI']) || preg_match('/\&Itemid\=118/', $_SERVER['REQUEST_URI'] )) : ?>
            <div class="container-fluid contentBlBlogHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="blogHeader">Блог</h1>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="container contentBlBlog">
            <div class="row">
                <div class="col-md-9 col-xs-12">
                    <jdoc:include type="component" />
                </div>
                <div class="col-md-3 cols-sm-0 col-xs-0 rightSideMenuBl">
                    <jdoc:include type="modules" name="rightSideMenuBl" />
                </div>
        </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="lastNews" style="xhtml" />
	<!-- -->
    <?php if (preg_match('/news/', $_SERVER['REQUEST_URI'])) : ?>
        <div class="container-fluid newsFluidBl">
            <div class="container">
                <jdoc:include type="component" />
            </div>
        </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="itOutsourcingCallInfoBl" style="xhtml" />

    <jdoc:include type="modules" name="itOutsourcingCalculator" style="xhtml" />

    <div class="container-fluid mainSliderBlock">
        <jdoc:include type="modules" name="mainSlider" />
    </div>

    <jdoc:include type="modules" name="partners" style="xhtml" />

    <jdoc:include type="modules" name="customModule" />

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

    <?php if ($_SERVER['REQUEST_URI'] == '/') : ?>
        <div class="container-fluid profitable-it-outsourcing">
            <div class="container">
                <div class="row">
                    <jdoc:include type="modules" name="profitableItOutsourcing" style="xhtml" />
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_SERVER['REQUEST_URI'] == '/' || preg_match('/contacts/', $_SERVER['REQUEST_URI']) || preg_match('/services\/outsourcing/', $_SERVER['REQUEST_URI'])) : ?>
        <div class="container-fluid">
            <div id="map"></div>
            <script>
                function initMap() {
                    var mapDiv = document.getElementById('map');
                    var map = new google.maps.Map(mapDiv, {
                        center: {lat: 50.3937181, lng: 30.6131583},
                        zoom: 16,
						scrollwheel: false
                    });

                    var marker = new google.maps.Marker({
                        position: {lat: 50.392080, lng: 30.6131391},
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

    <jdoc:include type="modules" name="reviews" style="xhtml" />

    <div class="pre-footer"></div>
    <footer class="container-fluid footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-12 copyright">&copy; 2016 &nbsp; <a href="/">Старлинк</a></div>
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
                <button type="button" class="modalFormCloseBtn close" data-dismiss="modal"></button>
                <jdoc:include type="modules" name="modalContactForm" />
            </div>
        </div>
    </div>

</body>

</html>
