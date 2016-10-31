<?php
// No direct access
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addStyleSheet('/media/mod_starlink_services_block/css/styles.css');
?>

<div class="row">
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="services/consulting">
      <span class="s-ServiceType__linkImage col-xs-4">
        <img src="images/services-icons/it-consulting-main.png" alt="" width="70" height="59"/>
      </span>
      <span class="s-ServiceType__linkHeader">IT-КОНСАЛТИНГ</span>
      <span class="s-ServiceType__linkText">Оптимизация и развитие IT-инфраструктуры</span>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="services/outsourcing">
      <span class="s-ServiceType__linkImage col-xs-4">
        <img src="images/services-icons/it-outsourcing-main.png" alt="" width="64" height="59"/>
      </span>
      <span class="s-ServiceType__linkHeader">IT-АУТСОРСИНГ</span>
      <span class="s-ServiceType__linkText">Мы – Ваш беспроблемный IT-департамент</span>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="services/integration">
      <span class="s-ServiceType__linkImage col-xs-4">
        <img src="images/services-icons/It-integration-main.png" alt="" width="60" height="60"/>
      </span>
      <span class="s-ServiceType__linkHeader">IT-ИНТЕГРАЦИЯ</span>
      <span class="s-ServiceType__linkText">Компьютеры, сети, программное обеспечение</span>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="services/datacenter">
      <span class="s-ServiceType__linkImage col-xs-4"> <img src="images/services-icons/data-center-main.png" alt="" width="60" height="60"/>
      </span>
      <span class="s-ServiceType__linkHeader">ДАТА-ЦЕНТР</span>
      <span class="s-ServiceType__linkText">Для тех, чей бизнес работает круглосуточно</span>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="services/security">
      <span class="s-ServiceType__linkImage col-xs-4">
        <img src="images/services-icons/security-main.png" alt="" width="45" height="60"/>
      </span>
      <span class="s-ServiceType__linkHeader">БЕЗОПАСНОСТЬ</span>
      <span class="s-ServiceType__linkText">Ваша информация – под надежной защитой
      </span>
    </a>
  </div>
  <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4">
    <a class="s-ServiceType" href="services/webprojects">
      <span class="s-ServiceType__linkImage col-xs-4">
        <img src="images/services-icons/web-project-main.png" alt="" width="67" height="51"/>
      </span>
      <span class="s-ServiceType__linkHeader">WEB-ПРОЕКТЫ</span>
      <span class="s-ServiceType__linkText">Сайты и интернет-приложения</span>
    </a>
  </div>
</div>

