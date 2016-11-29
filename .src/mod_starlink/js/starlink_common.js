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

});