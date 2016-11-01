<?php
// No direct access
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
$doc->addStyleSheet('/media/mod_starlink_map/css/styles.css');
$containerWide = $params->get('containerType');
?>

<div class="container-fluid">
  <?php if ( ! (bool) $containerWide ) {  echo '<div class="container">'; }  ?>
  <div id="map-canvas" <?php if ( ! (bool) $containerWide ) {  echo 'class="container"'; }  ?>>
  </div>
<!--  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcF4_JMyp4KWtLS_HwnKlAOw7Q9OCNleA&">
  </script>-->
  <!-- TODO map coordinates as module parameters -->
  <script>
      function initMap() {
        var mapOptions = {
          center:      new google.maps.LatLng(50.4070134, 30.6364289),
          zoom:        16,
          scrollwheel: false,
          mapTypeControl: true,
          mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_RIGHT
          },
          mapTypeId:   google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        var marker = new google.maps.Marker({
          position: {lat: 50.4070134, lng: 30.6364289},
          map: map,
          title: 'StarLink'
        });
      }
  </script>
  <script async defer
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcF4_JMyp4KWtLS_HwnKlAOw7Q9OCNleA&callback=initMap">
  </script>
</div>

