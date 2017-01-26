<?php
// No direct access
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
//$doc->addStyleSheet(JUri::base(true) . '/media/mod_starlink_services/css/starlink_services.css');
$containerWide = $params->get('containerType');

/*
 *  TODO: designer: convert icons to svg
 */


if ( ! (bool) $containerWide ) { echo '<div class="container">'; } ?>
<div class="row mb25">
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="/index.php?Itemid=105">
      <div class="s-ServiceType__imageWrap">
        <img class="s-ServiceType__icon" src="/media/mod_starlink_services/images/consulting.png" alt="" width="70" height="59">
      </div>
      <div class="s-ServiceType__details">
        <p class="s-ServiceType__linkHeader">IT-КОНСАЛТИНГ</p>
        <p class="s-ServiceType__linkText">Оптимизация и развитие IT-инфраструктуры</p>
      </div>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="index.php?Itemid=106">
      <div class="s-ServiceType__imageWrap">
        <img class="s-ServiceType__icon" src="/media/mod_starlink_services/images/outsourcing.png" alt="" width="64" height="59">
      </div>
      <div class="s-ServiceType__details">
        <p class="s-ServiceType__linkHeader">IT-АУТСОРСИНГ</p>
        <p class="s-ServiceType__linkText">Мы – Ваш беспроблемный IT-департамент</p>
      </div>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="index.php?Itemid=107">
      <div class="s-ServiceType__imageWrap">
        <img class="s-ServiceType__icon" src="/media/mod_starlink_services/images/integration.png" alt="" width="60" height="60">
      </div>
      <div class="s-ServiceType__details">
        <p class="s-ServiceType__linkHeader">IT-ИНТЕГРАЦИЯ</p>
        <p class="s-ServiceType__linkText">Компьютеры, сети, программное обеспечение</p>
      </div>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="index.php?Itemid=108">
      <div class="s-ServiceType__imageWrap">
        <img class="s-ServiceType__icon" src="/media/mod_starlink_services/images/data-center.png" alt="" width="60" height="60">
      </div>
      <div class="s-ServiceType__details">
        <p class="s-ServiceType__linkHeader">ДАТА-ЦЕНТР</p>
        <p class="s-ServiceType__linkText">Для тех, чей бизнес работает круглосуточно</p>
      </div>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="index.php?Itemid=109">
      <div class="s-ServiceType__imageWrap">
        <img class="s-ServiceType__icon" src="/media/mod_starlink_services/images/security.png" alt="" width="45" height="60">
      </div>
      <div class="s-ServiceType__details">
        <p class="s-ServiceType__linkHeader">БЕЗОПАСНОСТЬ</p>
        <p class="s-ServiceType__linkText">Ваша информация – под надежной защитой</p>
      </div>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="index.php?Itemid=110">
      <div class="s-ServiceType__imageWrap">
        <img class="s-ServiceType__icon" src="/media/mod_starlink_services/images/web-project.png" alt="" width="67" height="51">
      </div>
      <div class="s-ServiceType__details">
        <p class="s-ServiceType__linkHeader">WEB-ПРОЕКТЫ</p>
        <p class="s-ServiceType__linkText">Сайты и интернет-приложения &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
      </div>
    </a>
  </div>
</div>
<?php if ( ! (bool) $containerWide ) { echo '</div>'; }
