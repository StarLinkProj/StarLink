jQuery.noConflict();
jQuery(document).ready(function() {

    // input Masks

    // Add or reduce count of "planed leaves"
    jQuery('.minus').click(function () {
        var Sinput = jQuery(this).parent().find('input');
        var count = parseInt(Sinput.val()) - 1;
        count = count < 0 ? 0 : count;
        Sinput.val(count);
        Sinput.change();
        return false;
    });
    jQuery('.plus').click(function () {
        var Sinput = jQuery(this).parent().find('input');
        Sinput.val(parseInt(Sinput.val()) + 1);
        Sinput.change();
        return false;
    });

    // Add slider for PC
    jQuery("#slider-pc-count").slider({
        orientation: "vertical",
        //range: "min",
        min: 0,
        max: 60,
        value: 25,
        slideme: function( event1, ui2 ) {
            jQuery("#pcCount").val(ui2.value);
        }
    });
    jQuery("#pcCount").val(jQuery("#slider-pc-count").slider("value"));

    // Add slider for SERVER
    jQuery("#slider-server-count").slider({
        orientation: "vertical",
        min: 0,
        max: 15,
        value: 2,
        slideme: function( event, ui ) {
            jQuery("#serverCount").val(ui.value);
        }
    });
    jQuery("#serverCount").val(jQuery("#slider-server-count").slider("value"));

    // Add slider for VIRTUAL SERVER
    jQuery("#slider-virtual-count").slider({
        orientation: "vertical",
        min: 0,
        max: 15,
        value: 1,
        slideme: function( event, ui ) {
            jQuery("#virtualCount").val(ui.value);
        }
    });
    jQuery("#virtualCount").val(jQuery("#slider-virtual-count").slider("value"));


    // Parse admin data
    var pcPrice = jQuery("#pc_price").val();
    var serverPrice = jQuery("#server_price").val();
    var virtualPrice = jQuery("#virtual_server_price").val();
    var personalDevicePrice = jQuery("#personal_device_price").val();
    var additionalLeavePrice = jQuery("#additional_leave").val();
    var kursEuro = jQuery("#kurs_euro").val();
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

        var leavesCount1 = parseInt(jQuery("#leavesCount1").val());
        var leavesCount2 = parseInt(jQuery("#leavesCount2").val());
        var leavesCount3 = parseInt(jQuery("#leavesCount3").val());

        var serviceLevel = parseInt(jQuery("input[name=level]:checked").val());

        if(serviceLevel == 0) {
            //console.log("leavesCount1");
            result = pcCount*pcPriceArr[0] + serverCount*serverPriceArr[0] + virtualCount*virtualPriceArr[0] + leavesCount1*additionalLeavePriceArr[0];
        }

        if(serviceLevel == 1) {
            result = pcCount*pcPriceArr[1] + serverCount*serverPriceArr[1] + virtualCount*virtualPriceArr[1] + leavesCount2*additionalLeavePriceArr[1];
        }

        if(serviceLevel == 2) {
            result = pcCount*pcPriceArr[2] + serverCount*serverPriceArr[2] + virtualCount*virtualPriceArr[2] + leavesCount3*additionalLeavePriceArr[2];
        }

        result = Math.ceil(result*inflationPercent*kursEuro);

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
            swal('Значение более "15" нужно просчитывать с менеджером компании')
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

    // Change "Service level"
    jQuery("input[name='level']:radio").change(function() {
        calculateResult();
    })

    jQuery(".minus, .plus").click(function() {
        calculateResult();
    })

});