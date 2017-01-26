<?php
// No direct access
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$assetsPath = JURI::base( true ).$params->get('assetsBasePath', '/media/mod_starlink_calculator_outsourcing');
//$doc->addStyleSheet(JUri::base(true) . $assetsPath . '/css/starlink_calculator_outsourcing.css');
$imgBase = JUri::base(true) . '/media/mod_starlink_calculator_outsourcing/images';
?>

<section class="calcItOutsource">
  <div class="container">
    <h2 class="text-center">Как внедрять новейшие IT-технологии без большого и дорогостоящего IT-отдела?</h2>
    <p class="mx4 px4 mb35 text-center">Решение, которое мы предлагаем &ndash; передать обслуживание всей IT-инфраструктуры команде узкопрофильных специалистов.<br>
      Рассчитайте стоимость абонентского обслуживания ПК и серверов:</p>

    <div id="connect_form" class="row">

      <section class="mb35">
        <div class="flex">
          <div class="SLAtable__th SLAtable__th--left SlidersTable__col1 mt25" style="flex: 0 0 auto;">количество компьютеров</div>
          <div class="mt25 pr2" style="flex: 1 1 auto;">
            <div class="sliderContainer">
              <div id="slider-pc-count" class="Slider Slider--pc"></div>
            </div>
            <div class="digitContainer" id="slider-pc-count-digits">
              <?php for ($pcCountDigit = 0; $pcCountDigit <= 29; $pcCountDigit++) : ?>
                <span class="digit digit--pc" data-pcDigit="<?=$pcCountDigit?>"><?=$pcCountDigit?></span>
              <?php endfor; ?>
            </div>
          </div>
        </div>
        <div class="flex" style="flex-flow: row nowrap;">
          <div class="SLAtable__th SLAtable__th--left SlidersTable__col1 mt25" style="flex: 0 0 auto;">количество физических <br> серверов</div>
          <div class="mt25" style="flex: 1 1 36rem;">
            <div class="sliderContainer">
              <div id="slider-server-count" class="Slider Slider--server"></div>
            </div>
            <div class="digitContainer" id="slider-server-count-digits">
              <?php for ($serverCountDigit = 0; $serverCountDigit <= 15; $serverCountDigit++) : ?>
                <span class="digit digit--server" data-serverDigit="<?=$serverCountDigit?>"><?=$serverCountDigit?></span>
              <?php endfor; ?>
            </div>
          </div>
          <div class="SLAtable__th SLAtable__th--left SlidersTable__col3 mt25 ml3" style="flex: 0 0 auto;">количество виртуальных <br> серверов</div>
          <div class="mt25 pr2" style="flex: 1 0.67 16rem;">
            <div class="sliderContainer">
              <div id="slider-virtual-count" class="Slider Slider--virtual"></div>
            </div>
            <div class="digitContainer" id="slider-virtual-count-digits">
              <?php for ($serverCountDigit = 0; $serverCountDigit <= 7; $serverCountDigit++) : ?>
                <span class="digit digit--virtualServer" data-virtualDigit="<?=$serverCountDigit?>"><?=$serverCountDigit?></span>
              <?php endfor; ?>
            </div>
          </div>
        </div>
      </section>

      <table class="SLAtable">
        <thead class="">
          <tr class="">
            <th width="12%" class="SLAtable__th SLAtable__th--left">
              <img src="<?= $imgBase ?>/icons/calcServiceLevel.png" class=""></th>
            <th width="14%" class="SLAtable__th">
              <img src="<?= $imgBase ?>/icons/calcClockIcon.png" class=""></th>
            <th width="19%" class="SLAtable__th">
              <img src="<?= $imgBase ?>/icons/calcPersonIcon.png" class=""></th>
            <th width="20%" class="SLAtable__th">
              <img src="<?= $imgBase ?>/icons/calcVechicleIcon.png" class=""></th>
            <th width="25%" class="SLAtable__th">
              <img src="<?= $imgBase ?>/icons/calcVechicleIcon.png" class=""></th>
          </tr>
          <tr class="">
            <th class="SLAtable__th SLAtable__th--left py1">уровень<br>обслу&shy;жи&shy;ва&shy;ния</th>
            <th class="SLAtable__th py1">время реакции</th>
            <th class="SLAtable__th py1">выделенный персонал</th>
            <th class="SLAtable__th py1">аварийных выездов</th>
            <th class="SLAtable__th py1 pl2">плановых выездов</th>
          </tr>
        <tbody>
          <tr class="SLAtable__row">
            <th class="SLAtable__th SLAtable__th--left p2">
              <input class="display-none" type="radio" name="level" id="level1" value="0">
              <label class="SLAtable__label" for="level1"></label>
              <div class="">SLA 1</div>
            <td class=""> 1 час
            <td class=""> 1 чел.
            <td class=""> НЕОГРАНИЧЕНО
            <td class="pl2">
              <span class="sign sign--minus" id="minus1"></span>
              <input class="visits" type="text" name="leavesCount1" id="leavesCount1" value="0" size="2" readonly="readonly">
              <span class="sign sign--plus" id="plus1"></span>
            </td>
          </tr>
          <tr class="SLAtable__row">
            <th class="SLAtable__th SLAtable__th--left p2">
              <input class="display-none" type="radio" name="level" id="level2" value="1">
              <label class="SLAtable__label" for="level2"></label>
              <span class=""><br>SLA 2</span>
            <td class=""> 2 часа
            <td class=""> 1 чел.
            <td class=""> НЕОГРАНИЧЕНО
            <td class="pl2">
              <span class="sign sign--minus" id="minus1"></span>
              <input class="visits" type="text" name="leavesCount2" id="leavesCount2" value="0" size="2" readonly="readonly">
              <span class="sign sign--plus" id="plus1"></span>
            </td>
          </tr>
          <tr class="SLAtable__row">
            <th class="SLAtable__th SLAtable__th--left p2">
              <input class="display-none" type="radio" name="level" id="level3" value="2">
              <label class="SLAtable__label" for="level3"></label>
              <span class=""><br>SLA 3</span>
            <td class=""> 4 часа
            <td class=""> 1 чел.
            <td class=""> 1 ВЫЕЗД В МЕСЯЦ
            <td class="pl2">
              <span class="sign sign--minus" id="minus1"></span>
              <input class="visits" type="text" name="leavesCount3" id="leavesCount3" value="0" size="2" readonly="readonly">
              <span class="sign sign--plus" id="plus1"></span>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="SLAtable__summary">
        <div class="col-xs-3 SLAtable__th SLAtable__th--left pt2">стоимость обслуживания </div>
        <div class="col-xs-3 SLAtable__th px0">
          <input class="calcResult" type="text" name="calcResult" id="calcResult" value="0" readonly="">
          <span class=""><br>ГРН/МЕС</span>
        </div>
        <div class="col-sm-6 SLAtable__th pt1 pr3">
          <button type="submit" class="btnStarlink btn submit-button" data-toggle="modal" data-target="#modalContactFormBlock">
            Заказать
          </button>
        </div>
      </div>

      <!-- -->
      <input type="hidden" name="pc_price" id="pc_price" value="<?php print_r($params->get('pc_price')); ?>"/>
      <input type="hidden" name="server_price" id="server_price" value="<?php print_r($params->get('server_price')); ?>"/>
      <input type="hidden" name="virtual_server_price" id="virtual_server_price" value="<?php print_r($params->get('virtual_server_price')); ?>"/>
      <input type="hidden" name="personal_device_price" id="personal_device_price" value="<?php print_r($params->get('personal_device_price')); ?>"/>
      <input type="hidden" name="additional_leave" id="additional_leave" value="<?php print_r($params->get('additional_leave')); ?>"/>
      <input type="hidden" name="kurs_euro" id="kurs_euro" value="<?php print_r($params->get('kurs_euro')); ?>"/>
      <input type="hidden" name="inflation_percent" id="inflation_percent" value="<?php print_r($params->get('inflation_percent')); ?>"/>

      <input type="hidden" id="pcCount">
      <input type="hidden" id="serverCount">
      <input type="hidden" id="virtualCount">
    </div>
  </div>
</section>
