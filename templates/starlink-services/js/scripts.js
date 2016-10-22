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

    // Wrap every 3 news to block
    var newsBlock = jQuery('.blog>.row');
    while( newsBlock.children('div:not(.singleRow)' ).length){
      newsBlock.children('div:not(.singleRow):lt(3)').wrapAll('<div class="singleRow">');
    }
    jQuery('.blog>.row .singleRow').append('<div class="clear"></div>');

    // Change classes for last news block
    jQuery(".newsflash-lastNews").removeClass('container-fluid').removeClass('lastNews').addClass('container').addClass('blog');

    // Menu for screen width <767 (mobile):
    // Expand level 1 menu items with submenus instead of following the level 1 menu link
    jQuery("#mainmenu > li.deeper > a").click(function (e) {
      if (jQuery(window).width() <= 767) {
        e.preventDefault();
      }
      jQuery(this).parent().children('ul').toggle();
      jQuery(this).parent().toggleClass("expanded");
    );

    // Add hover style to parent el in main menu
    jQuery("#mainmenu > li > ul").hover(
      function () {
        /*jQuery(this).parent().children('a').css('color', '#ED1C24');*/
        if (jQuery(window).width() > 767) {
          jQuery(this).parent().addClass("expanded");
        }
      },
      function () {
        /*jQuery(this).parent().children('a').css('color', '#1b1b1b');*/
        if (jQuery(window).width() > 767) {
          jQuery(this).parent().removeClass("expanded");
        }
      }
    );

    // Search button changes
    jQuery('.searchButton').click(function() {
        jQuery('.mainMenuDiv').fadeOut(100);
        setTimeout(function() {
            jQuery('.searchLineDiv').fadeIn(200);
            jQuery('#mod-search-searchword').focus();
        }, 250);
    });
    jQuery('#mod-search-searchword').focusout(function() {
        jQuery('.searchLineDiv').fadeOut(100);
        setTimeout(function() {
            jQuery('.mainMenuDiv').fadeIn(100);
        }, 150);
    });

    // Pre-footer height
    jQuery('.pre-footer').css('height', jQuery('.footer').innerHeight());



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

});
