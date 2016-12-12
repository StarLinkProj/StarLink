<?php
// No direct access
defined('_JEXEC') or die;

$containerSuffix = (bool) $params->get('containerType') ? "-fluid" : "";
$mapHeight = $params->get('mapHeight', '400');
?>

<aside class="container<?=$containerSuffix?>" style="padding:0;">
  <div id="map-canvas" style="width: auto; height: <?=$mapHeight?>px;"></div>
</aside>
<script>
  function initMap() {
    var mapOptions = {
      center:         new google.maps.LatLng(50.4070134, 30.6364289),
      zoom:           16,
      scrollwheel:    false,
      mapTypeControl: true,
      mapTypeId:      google.maps.MapTypeId.ROADMAP,
      mapTypeControlOptions: {
        style:          google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        position:       google.maps.ControlPosition.TOP_RIGHT
      }
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    var marker = new google.maps.Marker({
      position: {
        lat: 50.4070134,
        lng: 30.6364289
      },
      map:      map,
      title:    'StarLink'
    });
  }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcF4_JMyp4KWtLS_HwnKlAOw7Q9OCNleA&callback=initMap">
</script>
