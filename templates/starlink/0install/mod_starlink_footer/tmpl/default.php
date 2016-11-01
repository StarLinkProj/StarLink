<?php
// No direct access
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addStyleSheet('/media/mod_starlink_footer/css/styles.css');
?>

<div class="pre-footer"></div>

<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-xs-12 copyright">
        © 2016 &nbsp; <a href="http://localhost:8000/">Старлинк</a>
      </div>
      <div class="col-md-6 col-xs-12">
        <ul class="nav menu " id="footerMenu">
          <li class="item-101 default">
            <a href="/index.php?option=com_content&view=featured&Itemid=101">Starlink</a>
          </li>
          <li class="item-111 parent">
            <a href="/index.php?option=com_content&view=article&id=2&Itemid=111">О компании</a>
          </li>
          <li class="item-112 parent">
            <a href="/index.php?option=com_content&view=article&id=17&Itemid=112">Услуги</a>
          </li>
          <li class="item-113 parent">
            <a href="#">Решения</a>
          </li>
          <li class="item-118 current active">
            <a href="/index.php?option=com_content&view=category&layout=blog&id=11&Itemid=118">Блог</a>
          </li>
          <li class="item-115">
            <a href="/index.php?option=com_content&view=article&id=1&Itemid=115">Контакты</a>
          </li>
        </ul>
      </div>
      <div class="col-md-3 col-xs-12">
        <div class="custom footerSocNetworks">
          <p>
            <a class="facebookIcon" href="https://www.facebook.com/StarlinkUA/" target="_blank">
              <img src="/media/mod_starlink/images/facebook.svg" alt=""/>
            </a>
            <a class="twitterIcon" href="https://twitter.com/StarlinkUa/" target="_blank">
              <img class="twitterIcon" src="/media/mod_starlink/images/twitter.svg" alt=""/>
            </a>
            <a class="googleIcon" href="https://plus.google.com/u/1/b/107580631455821459922/107580631455821459922?hl=uk" target="_blank">
              <img src="/media/mod_starlink/images/google+.svg" alt=""/>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>






