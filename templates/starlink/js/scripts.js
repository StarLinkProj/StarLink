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

    // Menu for screen width <767 (mobile):
    // Expand level 1 menu items with submenus instead of following the level 1 menu link
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

 // // TODO remove comments after checking
 // jQuery(window).scroll(function(){
 //     var headerAndTopBlHeight = jQuery("header").innerHeight() /*+ jQuery(".servicesBgBl1Margin").innerHeight()*/;
 //     if (jQuery(".secondaryConsultingMenuBl").length > 0) {    // TODO move this into 2nd .sticky addition instruction
 //         if(jQuery(window).scrollTop() > headerAndTopBlHeight) {
 //           /*jQuery('.scrollFixedConsultingBl').css('position', 'fixed');
 //           jQuery('body').css('margin-top', '200px');
 //           jQuery('.scrollBl').slideDown();*/
 //           jQuery('body>div.custom-services-image-header').addClass('sticky');
 //           jQuery('.scrollFixedConsultingBl').addClass('sticky');
 //         } else {
 //           jQuery('body>div.custom-services-image-header').removeClass('sticky');
 //           jQuery('.scrollFixedConsultingBl').removeClass('sticky');
 //           /*jQuery('.scrollFixedConsultingBl').css('position', 'relative');
 //           jQuery('body').css('margin-top', '0');
 ////           jQuery('.scrollBl').hide();*/
 //         }
 //     }
 // });

    // Wrap every 3 news to block
    var newsBlock = jQuery('.blog>.row');
    while( newsBlock.children('div:not(.singleRow)' ).length){
      newsBlock.children('div:not(.singleRow):lt(3)').wrapAll('<div class="singleRow">');
    }
    jQuery('.blog>.row .singleRow').append('<div class="clear"></div>');
});
