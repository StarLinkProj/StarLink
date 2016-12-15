

 /**
  * $gradient(): Generates unprefixed CSS value for gradient between ColorDarkm color1 and color2 at 0%, precent and 100% stops;
  * This vallue should be assigned to background-image CSS property and autoprefixed accordingly
  *
  * @param direction
  * @param colorDark
  * @param color1
  * @param color2
  * @param percent
  * @returns {string}
  */

function gradient(direction, colorDark, color1, color2, percent) {
  return 'linear-gradient(' + direction + ',' + colorDark + ' 0%,' + color1 + ' ' + percent + '%,' + color2 + ' ' + percent + '%,' + color2 + ' 100%)';
}






 /**
  * $getProperty(): gets calculated CSS property of #id element as it is before script execution
  *
  * @param id
  * @param property
  * @returns {string}
  */

 function getProperty(id, property) {
  var tempElement = document.getElementById(id);
  var tempStyle = window.getComputedStyle(tempElement);
  return tempStyle.getPropertyValue(property);
}





jQuery.noConflict();
jQuery(document).ready(function() {
  // check if calculator element exists on the page
  const CALC_ID = "#connect_form";
  if ( ! jQuery(CALC_ID).length ) {
    return;
  }

  var pcColor = getProperty('slider-pc-count', 'background-color');
  var pcDark = getProperty('slider-pc-count', 'border-left-color');
  var serverColor = getProperty('slider-server-count','background-color');
  var serverDark = getProperty('slider-server-count', 'border-left-color');
  var virtualColor = getProperty('slider-virtual-count','background-color');
  var virtualDark = getProperty('slider-virtual-count', 'border-left-color');
  var sliderColor = 'rgba(202,207,211,1)';

  // input Masks

  // Add or reduce count of "planed leaves"
  jQuery('.sign--minus').click(function () {
    var Sinput = jQuery(this).parent().find('input');
    var count = parseInt(Sinput.val()) - 1;
    count = count < 0 ? 0 : count;
    Sinput.val(count);
    Sinput.change();
    return false;
  });
  jQuery('.sign--plus').click(function () {
    var Sinput = jQuery(this).parent().find('input');
    Sinput.val(parseInt(Sinput.val()) + 1);
    Sinput.change();
    return false;
  });

  // Add slider for PC
  jQuery("#slider-pc-count").slider({
    orientation: "horizontal",
    min: 0,
    max: 29,
    value: 25,
    slideme: function( event, ui ) {
      jQuery("#pcCount").val(ui.value);

      // Change range color
      var val = (ui.value) / (30 - 1) * 100;

      jQuery(this).css('background-image', '-webkit-' + gradient('left', pcDark, pcColor, sliderColor, val));
      jQuery(this).css('background-image', gradient('to right', pcDark, pcColor, sliderColor, val));

      jQuery("#slider-pc-count-digits").find('.digit--active').removeClass('digit--active');
      jQuery("#slider-pc-count-digits").find("[data-pcdigit='" + ui.value + "']").addClass('digit--active');
    }
  });
  jQuery("#slider-pc-count-digits").find("[data-pcdigit='" + 25 + "']").addClass('digit--active');
  jQuery("#pcCount").val(jQuery("#slider-pc-count").slider("value"));

  // Add slider for SERVER
  jQuery("#slider-server-count").slider({
    orientation: "horizontal",
    min: 0,
    max: 15,
    value: 10,
    slideme: function( event, ui ) {
      jQuery("#serverCount").val(ui.value);

      // Change range color
      var val = (ui.value) / (16 - 1) * 100;

      jQuery(this).css('background-image', '-webkit-' + gradient('left', serverDark, serverColor, sliderColor, val));
      jQuery(this).css('background-image', gradient('to right', serverDark, serverColor, sliderColor, val));

      jQuery("#slider-server-count-digits").find('.digit--active').removeClass('digit--active');
      jQuery("#slider-server-count-digits").find("[data-serverdigit='" + ui.value + "']").addClass('digit--active');
    }
  });
  jQuery("#slider-server-count-digits").find("[data-serverdigit='" + 10 + "']").addClass('digit--active');
  jQuery("#serverCount").val(jQuery("#slider-server-count").slider("value"));

  // Add slider for VIRTUAL SERVER
  jQuery("#slider-virtual-count").slider({
    orientation: "horizontal",
    min: 0,
    max: 7,
    value: 5,
    slideme: function( event, ui ) {
      jQuery("#virtualCount").val(ui.value);

      // Change range color
      var val = (ui.value) / (8 - 1) * 100;

      jQuery(this).css('background-image', '-webkit-' + gradient('left', virtualDark, virtualColor, sliderColor, val));
      jQuery(this).css('background-image', gradient('to right', virtualDark, virtualColor, sliderColor, val));

      jQuery("#slider-virtual-count-digits").find('.digit--active').removeClass('digit--active');
      jQuery("#slider-virtual-count-digits").find("[data-virtualdigit='" + ui.value + "']").addClass('digit--active');
    }
  });
  jQuery("#slider-virtual-count-digits").find("[data-virtualdigit='" + 5 + "']").addClass('digit--active');
  jQuery("#virtualCount").val(jQuery("#slider-virtual-count").slider("value"));


  // Parse admin data
  var pcPrice = jQuery("#pc_price").val();
  var serverPrice = jQuery("#server_price").val();
  var virtualPrice = jQuery("#virtual_server_price").val();
  var personalDevicePrice = jQuery("#personal_device_price").val();
  var additionalLeavePrice = jQuery("#additional_leave").val();
  var kursEuro = parseFloat(jQuery("#kurs_euro").val());
  var inflationPercent = jQuery("#inflation_percent").val();

  var pcPriceArr = pcPrice.split("; ").map(Number);
  var serverPriceArr = serverPrice.split("; ").map(Number);
  var virtualPriceArr = virtualPrice.split("; ").map(Number);
  var personalDevicePriceArr = personalDevicePrice.split("; ").map(Number);
  var additionalLeavePriceArr = additionalLeavePrice.split("; ").map(Number);

  // Main calculate function
  function calculateResult() {
    var result = 0;
    var pcCount = parseInt(jQuery("#pcCount").val());
    var serverCount = parseInt(jQuery("#serverCount").val());
    var virtualCount = parseInt(jQuery("#virtualCount").val());
    var nTotalServ = serverCount + virtualCount;

    var leavesCount1 = parseInt(jQuery("#leavesCount1").val());
    var leavesCount2 = parseInt(jQuery("#leavesCount2").val());
    var leavesCount3 = parseInt(jQuery("#leavesCount3").val());

    var serviceLevel = parseInt(jQuery("input[name=level]:checked").val());

    var discount = Math.max( pcCount < 20 ? 0 : pcCount < 40 ? 0.1 : pcCount < 60 ? 0.2 : 0.25, nTotalServ < 6 ? 0 : nTotalServ < 12 ? 0.1 : 0.15 );

    if(serviceLevel == 0) {
      result = pcCount*pcPriceArr[0] + serverCount*serverPriceArr[0] + virtualCount*virtualPriceArr[0] + leavesCount1*additionalLeavePriceArr[0];
    }

    if(serviceLevel == 1) {
      result = pcCount*pcPriceArr[1] + serverCount*serverPriceArr[1] + virtualCount*virtualPriceArr[1] + leavesCount2*additionalLeavePriceArr[1];
    }

    if(serviceLevel == 2) {
      result = pcCount*pcPriceArr[2] + serverCount*serverPriceArr[2] + virtualCount*virtualPriceArr[2] + leavesCount3*additionalLeavePriceArr[2];
    }

    result = Math.round(result * inflationPercent * kursEuro * (1 - discount));

    jQuery("#calcResult").val(result);
  }

  // If CHANGE "#slider-pc-count"
  jQuery("#slider-pc-count").slider({
    change: function(event, ui) {
      calculateResult();
    }
  });

  // If CHANGE "input-pc-count"
  jQuery("#pcCount").change(function() {
    var pcCount = parseInt(jQuery(this).val());

    if(!pcCount || pcCount < 0) {
      pcCount = 0;
      jQuery(this).val(0);
    }

    if(pcCount > 60) {
      pcCount = 60;
      swal('Значение более "60" нужно просчитывать с менеджером компании');
      //alert('Значение более "60" нужно просчитывать с менеджером компании');
      jQuery(this).val(60);
    }

    jQuery("#slider-pc-count").slider({
      value: pcCount
    });

    jQuery(this).val(pcCount);

    calculateResult();
  });

  // If CHANGE "#slider-server-count"
  jQuery("#slider-server-count").slider({
    change: function(event, ui) {
      calculateResult();
    }
  });

  // If CHANGE "input-server-count"
  jQuery("#serverCount").change(function() {
    var serverCount = parseInt(jQuery(this).val());

    if(!serverCount || serverCount < 0) {
      serverCount = 0;
      jQuery(this).val(0);
    }

    if(serverCount > 15) {
      swal('Значение более "15" нужно просчитывать с менеджером компании');
      //alert('Значение более "15" нужно просчитывать с менеджером компании');
      jQuery(this).val(15);
      serverCount = 15;
    }

    jQuery("#slider-server-count").slider({
      value: serverCount
    });

    jQuery(this).val(serverCount);

    calculateResult();
  });

  // If CHANGE "#slider-virtual-count"
  jQuery("#slider-virtual-count").slider({
    change: function(event, ui) {
      calculateResult();
    }
  });

  // If CHANGE "input-server-count"
  jQuery("#virtualCount").change(function() {
    var virtualCount = parseInt(jQuery(this).val());

    if(!virtualCount || virtualCount < 0) {
      virtualCount = 0;
      jQuery(this).val(0);
    }

    if(virtualCount > 15) {
      swal('Значение более "15" нужно просчитывать с менеджером компании');
      //alert('Значение более "15" нужно просчитывать с менеджером компании');
      jQuery(this).val(15);
      virtualCount = 15;
    }

    jQuery("#slider-virtual-count").slider({
      value: virtualCount
    });

    jQuery(this).val(virtualCount);

    calculateResult();
  });


  jQuery(".sign").click(function() {
    calculateResult();
  });

  jQuery("input[name='level']").change(function() {
    jQuery('.SLAtable .SLAtable__row').removeClass('SLAtable__row--active');
    if (jQuery(this).is(':checked')) {
      jQuery(this).parent().parent().addClass('SLAtable__row--active');
    }
    calculateResult();
  });

});