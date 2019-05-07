<?php
// header('content-type: application/json');
// header("access-control-allow-origin: *");
if (isset($_GET['lat']) && $_GET['lng'] ) {
  if ((isset($_GET['lat'])=="") && (isset($_GET['lng'])=="")){
    $lat = -0.3209284;
    $lng = 100.3484996;
  }else{
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
  }
}else{
  $lat = -0.3209284;
  $lng = 100.3484996;
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <script src="js/script.js" charset="utf-8"></script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      var map;
      var lat = <?php echo $lat ?>;
      var lng = <?php echo $lng ?>;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: lat, lng: lng},
          zoom: 13,
          disableDefaultUI: true,

        });
        // map.data.LoadGeojson('https://gis-kotogadang.herokuapp.com/dataumkm.php');
        marker = new google.maps.Marker({
          position: latLng,
          title: 'Your Position',
          map: map
        });
        MarkerInfo(marker,'Your Position');

        var batasnagari;
				LoadGeoBangunan(batasnagari,'black',server+'mobile/batasnagari.php');
      }

    </script>
    <script src="js/jquery-3.4.0.min.js" charset="utf-8"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE&callback=initMap"
    async defer></script>

  </body>
</html>
  </body>
</html>
