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

  // Get current number of columns from css media query via border-right-width property
  // Inserts .clearfixes after every nColumns article block
  jQuery('.items-row').removeClass('clearfix');
  nColumns = jQuery(".span12:first").css("border-right-width").substring(0,1);
  jQuery('.items-row').each(function (index, value) {
    if ( (index+1) % nColumns == 0 ) {
      jQuery(this).addClass("clearfix");
    }
  });

  jQuery(window).resize(function () {
    jQuery('.items-row').removeClass('clearfix');
    nColumns = jQuery(".span12:first").css("border-right-width").substring(0,1);
    jQuery('.items-row').each(function (index, value) {
      if ( (index+1) % nColumns == 0 ) {
        jQuery(this).addClass("clearfix");
      }
    });
  });


  /*********** Search button ***********/

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


 /******* Other utilities ******/

 // Scroll bottom on about page
 jQuery("#aboutBottomScroll").click(function(e) {
   e.preventDefault();
   jQuery('html,body').animate({
         scrollTop: jQuery(".contentBl").offset().top - 30},
       'slow');
 });

 // Scroll to top page on scrollTopButton click
 jQuery(".scrollTopBtn").click(function() {
   jQuery('html,body').animate({
         scrollTop: jQuery("html").offset().top - 30},
       'slow');
 });

});


