jQuery(document).ready(function ($) {

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
