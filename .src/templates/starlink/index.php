<?php
  defined( '_JEXEC' ) or die;
  require_once JPATH_THEMES.'/'.$this->template.'/logic.php';
?>
<!doctype html>
<html lang="<?php echo $this->language; ?>">
<!-- template:<?php echo $this->template; ?> -->
<!--   itemId:<?php echo $itemId; ?>         -->
<head>
  <!--
       TODO bootstrap 3.3.7 plugins: collapse, transition, modal, buttons,
       TODO remove redundand & debug css/js in production:
       TODO replace with minified files the rest -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-W8KDD4');</script>
  <jdoc:include type="head" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
</head>

<body>
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8KDD4"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <?php include_once($assetsPathFile . '/images/icons.svg'); ?>
  <header class="TopHeader relative">
    <div class="TopRow relative">
      <div class="Logo absolute left-0 bottom-0" title="StarLink" href="<?php echo JURI::base(); ?>">
        <a href="<?php echo JURI::base(); ?>"><img class="Logo__image" src="<?=$assetsPath?>/images/logo-vector.svg"></a>
      </div>
      <div class="BackgroundHolder">
        <div class="Phone">
          <a href="tel:+380443777090">
            <svg class="icon iconPhone"><use xlink:href="#iconPhone" /></svg>
            <span class="Phone__areaCode">044</span><span>3777-090&nbsp;</span>
          </a>
        </div>
      </div>
      <div class="MenuToggleHolder">
        <nav class="navbar navbar--Starlink" role="navigation">
          <div class="navbar-header MenuToggleHolder__content">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#js-TopMenu__collapse" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
        </nav>
      </div>
    </div>
    <nav id="TopMenu" id="mainMenuDiv" class="navbar navbar--Starlink" role="navigation">
<!--      <div class="navbar-header MenuToggleHolder__content">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#js-TopMenu__collapse" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>-->
      <div class="collapse navbar-collapse" id="js-TopMenu__collapse" id="mainCollapse">
        <jdoc:include type="modules" name="s01-MainMenu" />
        <a href="javascript:void(0)" class="searchButton">
          <img src="/images/main/search_icon.png">
        </a>
      </div>
    </nav>

    <div class="hidden-xs hidden-sm col-md-6 col-lg-5 searchLineDiv">
      <jdoc:include type="modules" name="s02-Search" />
    </div>
  </header>

  <?php
  foreach (array('s03-HeroPosition', 's04-SubMenu', 's05-Offer') as $position) {
    if ($this->countModules($position)) : ?>
      <!-- begin jdoc:include type="modules" name="<?=$position?>" -->
        <jdoc:include type="modules" name="<?=$position?>" />
    <?php endif;
  } ?>

  <?php
/*    Not Menu Home, IT-консалтинг, IT-интеграция, Дата-центр, Безопасность, Web-проекты, Блог, Вакансии, Совместная работа сотрудников на базе продуктов Kerio,
		Безопасность и защита информации, Объединение распределенных офисов в единую сеть, 	IP-телефония и видеоконференции

            114 about/news - template Starlink-news
		        118 blog       - template Starlink-blog
		121 collaboration-kerio-connect,
    122 dataprotection-kerio-control,
    123 distributedorganization-starlink,
    124 conferencing-kerio-operator

    то есть
		105 consulting
    106 IT-outsourcing
    107 integration
		108 datacenter
    109 security
    110 webprojects
    111 О компании
    112 Услуги,
    113 Решения,
    115 Контакты,
    117 Кто мы?,
    119 Портфолио,
    120 Вакансии
    134 Виртуализация,
    135 Хостинг / Колокейшн,
    136 Аренда серверов и ПО (SaaS),
    137 SSL-сертификаты,
    138 аналы связи,
 */
  ?>

  <main>
  <?php if (!in_array($itemId, [122, 123, 124])) : ?>
  <!-- BEGIN jdoc:include type="component" -->
    <jdoc:include type="component"/>
  <?php endif; ?>
  </main>


  <?php
  foreach (array('s06-Details', 's07-AllServices', 's08-CalltoAction', 's09-InfoBlock', 's10-BottomBlock') as $position) {
    if ($this->countModules($position)) : ?>
      <!-- begin jdoc:include type="modules" name="<?=$position?>" -->
        <jdoc:include type="modules" name="<?=$position?>" />
    <?php endif;
  } ?>

  <div class="pre-footer"></div>
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-xs-12 copyright h5 footer__row">
          &copy; 2016 &nbsp; <a class="footer__link" href="<?php echo JURI::base(); ?>">Старлинк</a>
        </div>
        <div class="col-md-6 col-xs-12 h5 footer__row">
          <jdoc:include type="modules" name="s80-FooterMenu" />
        </div>
        <div class="col-md-3 col-xs-12 h4 my0">
          <div class="footer__socialBlock text-center">
            <a class="footer__link footer__icon inline-block mr2" href="https://www.facebook.com/StarlinkUA/" target="_blank">
              <svg version="1.1"
                   class="footer__svg footer__svg_facebook"
                   baseProfile="full"
                   height="100" width="100"
                   fill="#3b5998"
                   viewBox="10 0 190 385"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M198,64.533c-75.981-3.327-70.282,3.784-69,76c22.331,0.333,44.669,0.667,67,1c-3,22.331-6,44.669-9,67 c-19.331,0-38.669,0-58,0c0,58.661,0,117.339,0,176c-23.664,0-47.336,0-71,0c0.333-58.327,0.667-116.672,1-175c-0.333-0.333-0.667-0.667-1-1c19.331,0-38.669,0-58,0c0-22.664,0-45.336,0-68c19.665,0,39.335,0,59,0c0-16.998,0-34.002,0-51 c0.171-70.276,43.131-100.464,139-86C198,23.865,198,44.202,198,64.533z"/>
              </svg>
            </a>
            <a class="footer__link footer__icon inline-block mr2" href="https://twitter.com/StarlinkUa/" target="_blank">
              <svg version="1.1"
                   class="footer__svg footer__svg_twitter"
                   baseProfile="full"
                   fill="#00aced"
                   height="95" width="115"
                   viewBox="701 1245 105 79"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M802,1252.734c-3.679,1.632-7.633,2.734-11.783,3.23c4.235-2.539,7.489-6.559,9.021-11.35	c-3.964,2.351-8.355,4.058-13.029,4.979c-3.742-3.988-9.074-6.479-14.975-6.479c-11.33,0-20.516,9.185-20.516,20.516	c0,1.608,0.181,3.174,0.531,4.675c-17.051-0.855-32.168-9.023-42.287-21.436c-1.766,3.03-2.778,6.554-2.778,10.314	c0,7.118,3.622,13.397,9.127,17.077c-3.363-0.107-6.527-1.03-9.293-2.566c-0.002,0.086-0.002,0.171-0.002,0.258	c0,9.94,7.072,18.232,16.457,20.117c-1.721,0.469-3.534,0.72-5.405,0.72c-1.322,0-2.607-0.129-3.86-0.368	c2.611,8.15,10.188,14.082,19.165,14.247c-7.021,5.503-15.868,8.783-25.48,8.783c-1.656,0-3.289-0.097-4.894-0.287	c9.079,5.821,19.864,9.218,31.449,9.218c37.737,0,58.373-31.262,58.373-58.373c0-0.89-0.021-1.774-0.06-2.654 	C795.771,1260.462,799.25,1256.849,802,1252.734"/>
              </svg>
            </a>
            <a class="footer__link footer__icon inline-block" href="https://plus.google.com/u/1/b/107580631455821459922/107580631455821459922?hl=uk" target="_blank">
              <svg version="1.1"
                   class="footer__svg footer__svg_googlePlus"
                   baseProfile="full"
                   height="63.5" width="100"
                   fill="#DD4B39"
                   viewBox="-251 470 100 70"
                   xmlns="http://www.w3.org/2000/svg">
                <g>
                  <path d="M-215.2,498.1c0,3.6,0,7.2,0,10.8c6.1,0.2,12.1,0.1,18.2,0.2c-2.7,13.4-20.9,17.8-30.6,9		c-9.9-7.7-9.5-24.6,0.9-31.7c7.2-5.8,17.5-4.3,24.7,0.7c2.8-2.6,5.5-5.4,8.1-8.3c-6-4.8-13.4-8.2-21.2-7.8		c-16.4-0.5-31.4,13.8-31.7,30.1c-1,13.4,7.7,26.5,20.2,31.2c12.4,4.8,28.2,1.5,36.1-9.6c5.2-7,6.3-16.1,5.7-24.6		C-195,498.1-205.1,498.1-215.2,498.1z"/>
                  <path d="M-156.1,498.1c0-3,0-6.1-0.1-9.1c-3,0-6,0-9,0c0,3-0.1,6-0.1,9.1c-3,0-6.1,0-9.1,0.1c0,3,0,6,0,9		c3,0,6.1,0.1,9.1,0.1c0,3,0,6,0.1,9.1c3,0,6,0,9,0c0-3,0-6,0.1-9.1c3,0,6.1,0,9.1-0.1c0-3,0-6,0-9		C-150,498.1-153.1,498.1-156.1,498.1z"/>
                </g>
              </svg>
            </a>
            <svg class="icon iconFacebook"><use xlink:href="#iconFacebook" /></svg>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalContactFormBlock" id="modalContactFormBlock">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="modalFormCloseBtn close" data-dismiss="modal" aria-hidden="true"></button>
          <h2 class="header mt2 mb0">Отправить заявку на абонентское обслуживание</h2>
        </div>
        <jdoc:include type="modules" name="s99-ModalContactForm" />
        <div class="mb2"></div>
      </div>
    </div>
  </div>
  <div class="modal fade" role="dialog" aria-labelledby="modalThankYouOutsourcing" id="modalThankYouOutsourcing">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="modalFormCloseBtn close" data-dismiss="modal" aria-hidden="true"></button>
          <h2 class="header mt2 mb0">Ваша заявка успешно отправлена</h2>
        </div>
        <div class="modal-body">
          <p class="article__text">Спасибо за ваше обращение! Наши специалисты ответят на Ваш запрос в ближайшее время.</p>
        </div>
      </div>
      <div class="js-thankYouOutsourcing">
        <h2 class="header mt2 mb3">Ваша заявка успешно отправлена</h2>
        <p class="article__text">Спасибо за ваше обращение! Наши специалисты ответят на Ваш запрос в ближайшее время.</p>
      </div>
    </div>
  </div>

</body>

</html>
