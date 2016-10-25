jQuery(document).ready(function ($) {

  /******** Menu utilities ********/

  // Menu for screen width <767 (mobile):
  // Expand level 1 menu items with submenus instead of following the level 1 menu link
  jQuery("#mainmenu > li.deeper > a").click(function (e) {
    if (jQuery(window).width() <= 767) {
      e.preventDefault();
      jQuery(this).siblings('ul').toggle(250, "swing", true);                               // show or hide submeny of currently clicked item
      jQuery(this).parent().siblings("li.deeper").children("ul").hide(250, "swing", true);  // hide sibling submenus in any case
      jQuery.dequeue();
      jQuery(this).parent().toggleClass("expanded");
    }
  });

  // Add hover style to parent menu item in main menu
  jQuery("#mainmenu > li > ul").hover(
          function () {
            if (jQuery(window).width() > 767) {
              jQuery(this).parent().addClass("expanded");
            }
          },
          function () {
            if (jQuery(window).width() > 767) {
              jQuery(this).parent().removeClass("expanded");
            }
          }
  );

  // Hide expanded submenus when screen becomes wider than mobile
  jQuery(window).resize(function () {
    if (jQuery('.container').width() >= 720) {
      jQuery("#mainmenu > li.deeper > ul").hide();
      jQuery("#mainmenu > li.deeper > ul").removeAttr("style");
    }
  });


  /*****   FOOTER UTILITIES  *******/

  // make last container-fluid before footer 100% width of screen
  jQuery('.pre-footer').prev('.container-fluid').css('width','100%');


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
  });


  /***********     SERVICES  ************/

  // Change img source on services hover
  jQuery(".services .services-a").hover(function () {
    var oldSrc = $(this).find('img').attr("src");
    if (!oldSrc.match(/\-hover\.png/)) {
      var newSrc = oldSrc.replace(/\-main\.png/, "-hover.png");
      $(this).find('img').attr("src", newSrc);
    }
  }, function () {
    var oldSrc = $(this).find('img').attr("src");
    if (!oldSrc.match(/\-main\.png/)) {
      var newSrc = oldSrc.replace(/\-hover\.png/, "-main.png");
      $(this).find('img').attr("src", newSrc);
    }
  });

  /*****  NEWS   and   BLOG  pages  ******/

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



  /*********** Search button ***********/

  // Search button changes
  jQuery('.searchButton').click(function () {
    jQuery('.mainMenuDiv').fadeOut(100);
    setTimeout(function () {
      jQuery('.searchLineDiv').fadeIn(200);
      jQuery('#mod-search-searchword').focus();
    }, 250);
  });
  jQuery('#mod-search-searchword').focusout(function () {
    jQuery('.searchLineDiv').fadeOut(100);
    setTimeout(function () {
      jQuery('.mainMenuDiv').fadeIn(100);
    }, 150);
  });


  /****** Sticky menu on /services pages ******/

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


  /******* Other utilities ******/

  // Scroll bottom on about page
  jQuery("#aboutBottomScroll").click(function (e) {
    e.preventDefault();
    jQuery('html,body').animate({
              scrollTop: jQuery(".contentBl").offset().top - 30
            },
            'slow');
  });

  // Scroll to top page on scrollTopButton click
  jQuery(".scrollTopBtn").click(function () {
    jQuery('html,body').animate({
              scrollTop: jQuery("html").offset().top - 30
            },
            'slow');
  });


  /*********   CONTACT FORMS   **********/

  // Add required attribute for input fields Fox with class='foxContactAddRequired'
  jQuery('.foxContactAddRequired input[type="text"]').attr('required', true);
  jQuery('.foxContactAddTypeEmail input[type="text"]').attr('type', 'email');

  // Change modal text before submit form IT-outsourcing
  jQuery('form[name="fox-form-m115"]').submit(function (e) {
    var form = this;
    e.preventDefault();

    jQuery('#fox-container-m115').prepend('<div class="modalFormCongratulation" xmlns="http://www.w3.org/1999/html"><h2>Ваша заявка успешно отправлена</h2><p>Спасибо за ваше обращение! Наши специалисты ответят на Ваш запрос в ближайшее время.</p></div>');

    setTimeout(function () {
      form.submit();
    }, 3000);
  });


  /*****   IT OUTSOURCING PAGE   *****/

  // Change classes for IT outsourcing top block
  jQuery(".custom-itOutsourcingTopBlWithBg").removeClass('container-fluid').removeClass('itOutsourcingTopBlWithBg').addClass('container');
  jQuery(".custom-itOutsourcingWeProposeYou").removeClass('container-fluid').removeClass('itOutsourcingWeProposeYou').addClass('container');
  jQuery(".custom-itOutsourcingCallInfoBl").removeClass('container-fluid').removeClass('itOutsourcingCallInfoBl').addClass('container');

  // Scroll bottom on IT outsourcing page
  jQuery("#itOutsourcingBottomScroll").click(function (e) {
    e.preventDefault();
    jQuery('html,body').animate({
              scrollTop: jQuery(".contentBl").offset().top - 30
            },
            'slow');
  });


  /****   PARTNERS  ****/

  jQuery(".moduletable-partners").children("div").removeClass('container');
  jQuery(".moduletable-reviewsBl").children("div").removeClass('container').removeClass('reviewsBl');
  jQuery(".fox-column12").children().wrapAll('<div class="row" />');


  /****  CONTACTS  ****/

  // Place map on the first place on contacts page
  if ((window.location.href).match(/contacts/)) {
    jQuery("#map").parent().detach().insertAfter('header');
  }

});
