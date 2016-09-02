jQuery(document).ready(function($) {

    // Change img source on services hover
    jQuery(".services .services-a").hover(function() {
        var oldSrc = $(this).find('img').attr("src");
        if (!oldSrc.match(/\-hover\.png/)) {
            var newSrc = oldSrc.replace(/\-main\.png/, "-hover.png");
            $(this).find('img').attr("src", newSrc);
        }
    }, function() {
        var oldSrc = $(this).find('img').attr("src");
        if (!oldSrc.match(/\-main\.png/)) {
            var newSrc = oldSrc.replace(/\-hover\.png/, "-main.png");
            $(this).find('img').attr("src", newSrc);
        }
    })

    // Change img source on footer soc hover
    jQuery(".footerSocNetworks a").hover(function() {
        var oldSrc = $(this).find('img').attr("src");
        if (!oldSrc.match(/\-hover\.png/)) {
            var newSrc = oldSrc.replace(/\-main\.png/, "-hover.png");
            $(this).find('img').attr("src", newSrc);
        }
    }, function() {
        var oldSrc = $(this).find('img').attr("src");
        if (!oldSrc.match(/\-main\.png/)) {
            var newSrc = oldSrc.replace(/\-hover\.png/, "-main.png");
            $(this).find('img').attr("src", newSrc);
        }
    })

    // Change modules order on contacts page
    if ((window.location.href).match(/contacts/)) {
        jQuery("#map").parent().detach().insertAfter('header');
    }

    jQuery(".moduletable-partners").children("div").removeClass('container');
    jQuery(".moduletable-reviewsBl").children("div").removeClass('container').removeClass('reviewsBl');

    jQuery(".fox-column12").children().wrapAll('<div class="row" />');

    // Scroll bottom on about page
    jQuery("#aboutBottomScroll").click(function(e) {
        e.preventDefault();
        jQuery('html,body').animate({
                scrollTop: jQuery(".contentBl").offset().top - 30},
            'slow');
    });

    // Show more news on Blog page
    var singleNews = jQuery(".newsFluidBl .blog .row .items-row");
    var newsCount = singleNews.size();
    singleNews.hide();
    var loadNewsOneTimeCount = 6;
    jQuery('.newsFluidBl .blog .row .items-row:lt(' + loadNewsOneTimeCount + ')').show();
    jQuery('.newsShowMoreNews').click(function () {
        loadNewsOneTimeCount = (loadNewsOneTimeCount + loadNewsOneTimeCount <= newsCount) ? loadNewsOneTimeCount + loadNewsOneTimeCount : newsCount;
        jQuery('.newsFluidBl .blog .row .items-row:lt(' + loadNewsOneTimeCount + ')').delay(200).slideDown(800);
        if(loadNewsOneTimeCount == newsCount){
            jQuery('.newsShowMoreNews').delay(800).slideUp(100);
        }
    });

    // Add hover style to parent el in main menu
    jQuery("#mainmenu>li>ul.nav-child>li>a").hover(
        function() {
            jQuery(this).parent().parent().parent().children('a').css('color', '#ED1C24');
        },
        function() {
            jQuery(this).parent().parent().parent().children('a').css('color', '#1b1b1b');
        }
    );

    // Change padding in Sevices-bl block
    if (jQuery(".services-bl>.container>.row").children().length < 1) {
        jQuery(".services-bl").hide();
    }

    // Change classes for last news block
    jQuery(".newsflash-lastNews").removeClass('container-fluid').removeClass('lastNews').addClass('container').addClass('blog');

    // Change classes for IT outsourcing top block
    jQuery(".custom-itOutsourcingTopBlWithBg").removeClass('container-fluid').removeClass('itOutsourcingTopBlWithBg').addClass('container');
    jQuery(".custom-itOutsourcingWeProposeYou").removeClass('container-fluid').removeClass('itOutsourcingWeProposeYou').addClass('container');
    jQuery(".custom-itOutsourcingCallInfoBl").removeClass('container-fluid').removeClass('itOutsourcingCallInfoBl').addClass('container');

    // Scroll bottom on IT outsourcing page
    jQuery("#itOutsourcingBottomScroll").click(function(e) {
        e.preventDefault();
        jQuery('html,body').animate({
                scrollTop: jQuery(".contentBl").offset().top - 30},
            'slow');
    });


    // Search button changes
    jQuery('.searchButton').click(function() {
        jQuery('.topPhoneDiv').fadeOut(100);
        jQuery('.mainMenuDiv').fadeOut(100);
        setTimeout(function() {
            jQuery('.searchLineDiv').fadeIn(200);
            jQuery('#mod-search-searchword').focus();
        }, 250);
    });
    jQuery('#mod-search-searchword').focusout(function() {
        jQuery('.searchLineDiv').fadeOut(100);
        setTimeout(function() {
            jQuery('.topPhoneDiv').fadeIn(100);
            jQuery('.mainMenuDiv').fadeIn(100);
        }, 150);
    });

    // Pre-footer height
    jQuery('.pre-footer').css('height', jQuery('.footer').innerHeight());

    // Add required attribute for input fields Fox with class='foxContactAddRequired'
    jQuery('.foxContactAddRequired input[type="text"]').attr('required', true);
    jQuery('.foxContactAddTypeEmail input[type="text"]').attr('type', 'email');

    // Change modal text before submit form IT-outsourcing
    jQuery('form[name="fox-form-m115"]').submit(function(e) {
        var form = this;
        e.preventDefault();

        jQuery('#fox-container-m115').prepend('<div class="modalFormCongratulation" xmlns="http://www.w3.org/1999/html"><h2>Ваша заявка успешно отправлена</h2><p>Спасибо за ваше обращение! Наши специалисты ответят на Ваш запрос в ближайшее время.</p></div>');

        setTimeout(function() {
            form.submit();
        }, 3000);
    });

    // Menu for screen width (768-991)
    function tabletMenuChange() {
        if (jQuery(window).width() >= 752 && jQuery(window).width() <= 975) {
            if (jQuery('.tabletMainMenu').length == 0) {
                jQuery("<div class='container-fluid tabletMainMenu'></div>").insertAfter("header");
                jQuery(".mainMenuDiv").addClass("tabletMainMenuDiv").detach().appendTo('.tabletMainMenu');
            }
        } else {
            if (jQuery('.tabletMainMenu').length == 1) {
                jQuery(".mainMenuDiv").removeClass("tabletMainMenuDiv").detach().insertAfter('.topPhoneDiv');
                jQuery('.tabletMainMenu').detach();
            }
        }
    }
    tabletMenuChange();
    $( window ).resize(function() {
        tabletMenuChange()
    });

    // Menu for screen width <767 (mobile)
    if (jQuery(window).width() <= 767) {
        jQuery("#mainmenu > .deeper > a").click(function (e) {
            e.preventDefault();
            jQuery(this).parent().find('ul.nav-child').toggle();
        });
    }

    // Scroll to top page on scrollTopButton click
    jQuery(".scrollTopBtn").click(function() {
        jQuery('html,body').animate({
                scrollTop: jQuery("html").offset().top - 30},
            'slow');
    });

    jQuery(window).scroll(function(){
        var headerAndTopBlHeight = jQuery("header").innerHeight() + jQuery(".servicesBgBl1Margin").innerHeight() + 20;

        if (jQuery(".secondaryConsultingMenuBl").length > 0) {
            if(jQuery(window).scrollTop() > headerAndTopBlHeight){
                jQuery('.scrollFixedConsultingBl').css('position', 'fixed');
                jQuery('body').css('margin-top', '200px');
                jQuery('.scrollBl').slideDown();
            } else {
                jQuery('.scrollFixedConsultingBl').css('position', 'relative');
                jQuery('body').css('margin-top', '0');
                jQuery('.scrollBl').hide();
            }
        }
    });


    // Header for desktop with width < 767px
    function headerDesktopChange() {
        var phoneText = '';
        if (jQuery(window).width() <= 767) {
            if (jQuery('header .row .container-fluid .topPhoneMobile').length == 0) {
                phoneText = jQuery('.topPhoneDiv .custom');
                jQuery('.topPhoneDiv').detach();
                jQuery('header .row').prepend('<div class="container-fluid"><div class="topPhoneMobile"></div></div>');
                jQuery('.topPhoneMobile').append(phoneText);
                jQuery('head').append('<script src="' + myDomain + '/templates/starlink/js/libs/bootstrap.min.js" type="text/javascript"></script>');
            }
        } else {
            if (jQuery('header .row .container-fluid .topPhoneMobile').length > 0) {
                phoneText = jQuery('.topPhoneMobile .custom');
                jQuery('header .row .container-fluid').detach();
                jQuery('<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 topPhoneDiv"></div>').insertAfter(jQuery('header .row .logo'));
                jQuery('.topPhoneDiv').append(phoneText);
                jQuery('<script src="' + myDomain + '/templates/starlink/js/libs/bootstrap.min.js" type="text/javascript"></script>').detach('');
            }
        }
    }
    headerDesktopChange();
    $( window ).resize(function() {
        headerDesktopChange()
    });
});
