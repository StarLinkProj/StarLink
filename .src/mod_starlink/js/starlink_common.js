/**
 * Created by mao on 05.11.2016.
 *
 * This code is shared by all Starlink templates and should be explicitly added by template code
 *
 */

jQuery(document).ready(function($) {

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
    if (jQuery('.container').width() >= 720 ) {
      jQuery("#mainmenu > li.deeper > ul").hide();
      jQuery("#mainmenu > li.deeper > ul").removeAttr("style");
    }
  });


  /*****   FOOTER UTILITIES  *******/

  // Change img source on footer soc hover
/*
  jQuery(".footerSocNetworks a").hover(function () {
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
*/


  /*********** SEARCH BUTTON ***********/

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


  /*********   CONTACT FORMS   **********/

  // Add required attribute for input fields Fox with class='foxContactAddRequired'
  jQuery('.foxContactAddRequired input[type="text"]').attr('required', true);
  jQuery('.foxContactAddTypeEmail input[type="text"]').attr('type', 'email');

  // Change modal text before submit form IT-outsourcing
  jQuery('form[name="fox-form-m115"]').submit(function (e) {
    var form = this;
    e.preventDefault();

    jQuery('#modalContactFormBlock').modal('hide');
    jQuery('#modalThankYouOutsourcing').modal('show');

    setTimeout(function () {
      form.submit();
    }, 3000);
  });


  /******* Other utilities ******/

  // Scroll bottom on about page
  jQuery(".aboutCompany__bottomArrow").click( function (e) {
    e.preventDefault();
    jQuery('html, body').animate({
              scrollTop: jQuery(".article").offset().top - 30
            },
            'slow');
  });

  // Scroll to top page on scrollTopButton click
  jQuery(".scrollTopBtn").click(function () {
    jQuery('html, body').animate({
              scrollTop: jQuery("html").offset().top - 30
            },
            'slow');
  });

  // Scroll bottom on IT outsourcing page
  jQuery(".bottomScroll.bottomScroll--outsourcing").click(function (e) {
    e.preventDefault();
    jQuery('html,body').animate({
              scrollTop: jQuery(".article").offset().top - 30
            },
            'slow');
  });


});