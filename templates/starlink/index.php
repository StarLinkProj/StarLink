<?php defined( '_JEXEC' ) or die; 

include_once JPATH_THEMES.'/'.$this->template.'/logic.php';

?><!doctype html>

<html lang="<?php echo $this->language; ?>">

<head>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/templates/starlink/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="/templates/starlink/css/helvetica.css" type="text/css">
    <jdoc:include type="head" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <script src="/templates/starlink/js/libs/bootstrap.min.js" type="text/javascript"></script>
    <script src="/templates/starlink/js/scripts.js" type="text/javascript"></script>
</head>
  
<body>

    <header class="container">
        <div class="row">
            <div class="logo col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <a title="StarLink" href="http://starlink.pp.ua/">
                    <img src="/images/main/logo.png" alt="logo"  class="logo-img">
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <jdoc:include type="modules" name="topPhone" />
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <?php if (preg_match('/about/', $_SERVER['REQUEST_URI'])) : ?>
        <div class="container-fluid aboutPageBl">
            <div class="container">
                <jdoc:include type="modules" name="aboutPageBl" />
            </div>
        </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="servicesTopBlWithBg" />

    <jdoc:include type="modules" name="itOutsourcingTopBlWithBg" style="xhtml" />

    <jdoc:include type="modules" name="itOutsourcingWeProposeYou" style="xhtml" />

    <?php if ($_SERVER['REQUEST_URI'] != '/' && !preg_match('/news/', $_SERVER['REQUEST_URI'])) : ?>
        <div class="container contentBl">
            <jdoc:include type="component" />
        </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="lastNews" style="xhtml" />

    <?php if (preg_match('/news/', $_SERVER['REQUEST_URI'])) : ?>
        <div class="container-fluid blogFluidBl">
            <div class="container">
                <jdoc:include type="component" />
            </div>
        </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="itOutsourcingCallInfoBl" style="xhtml" />

    <jdoc:include type="modules" name="itOutsourcingCalculator" style="xhtml" />

    <div class="container-fluid">
        <jdoc:include type="modules" name="mainSlider" />
    </div>

    <jdoc:include type="modules" name="partners" style="xhtml" />

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

    <?php if ($_SERVER['REQUEST_URI'] == '/' || preg_match('/contacts/', $_SERVER['REQUEST_URI']) || preg_match('/services\/it-outsourcing/', $_SERVER['REQUEST_URI'])) : ?>
        <div class="container-fluid">
            <div id="map"></div>
            <script>
                function initMap() {
                    var mapDiv = document.getElementById('map');
                    var map = new google.maps.Map(mapDiv, {
                        center: {lat: 50.3937181, lng: 30.6131583},
                        zoom: 16
                    });

                    var marker = new google.maps.Marker({
                        position: {lat: 50.392080, lng: 30.6131391},
                        map: map,
                        title: 'StarLink'
                    });
                }
            </script>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpYNHKQLUxAJaT8jwcXYVXKGCN--0URuE&callback=initMap">
            </script>
        </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="reviews" style="xhtml" />

    <footer class="container-fluid footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12 copyright">Starlink <sup>тм</sup> - &copy; 2007-<?php echo date("Y"); ?></div>
                <div class="col-md-6 col-sm-4 col-xs-0">
                    <jdoc:include type="modules" name="footerMenu" />
                </div>
                <div class="col-md-3 col-sm-5 col-xs-12">
                    <jdoc:include type="modules" name="footerSocNetworks" />
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
