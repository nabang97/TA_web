<?php
require '../mobile/koneksi.php';

if (isset($_GET["jorong"])) {
  // code...

  $j_id = $_GET["jorong"];

  $querysearch = " 	SELECT
  					M.msme_building_id,
  					M.name_of_msme_building,
  					M.geom,
  					ST_X(ST_CENTROID(M.geom)) as longitude,
  					ST_Y(ST_CENTROID(M.geom)) as latitude
  					FROM msme_building AS M, jorong AS J
  					WHERE ST_CONTAINS(J.geom, M.geom) and J.jorong_id='$j_id'";

  $hasil = pg_query($querysearch);
  while ($row = pg_fetch_array($hasil)) {
      $id = $row['msme_building_id'];
      $name = $row['name_of_msme_building'];
      $longitude = $row['longitude'];
      $latitude = $row['latitude'];
      $dataarray[] = array('id' => $id, 'name' => $name, 'longitude' => $longitude, 'latitude' => $latitude);
  }
 //echo json_encode($dataarray);
}
?>


    <!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
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
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -0.3209284, lng: 100.3484996},
          zoom: 13
        });
        // map.data.LoadGeojson('https://gis-kotogadang.herokuapp.com/dataumkm.php');
        var layernya = new google.maps.Data();
                           layernya.loadGeoJson('https://gis-kotogadang.herokuapp.com/batasnagari.php');
                           layernya.setMap(map);
        var a = <?php echo json_encode($dataarray); ?>;
        console.log(a);
        console.log(a.length);
        panjang=a.length;
        // var layernya = new google.maps.Data();
        //                    layernya.loadGeoJson(a);
        //                    layernya.setMap(map);
        console.log(a[0]['latitude']);
          for (i=0; i < panjang; i++) {
            var myLatLng = {lat: parseFloat(a[i]['latitude']), lng: parseFloat(a[i]['longitude'])};
            var marker = new google.maps.Marker({
               position: myLatLng,
               map: map,
               title: a[i]['name']
              });

         }

        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE&callback=initMap"
    async defer></script>
  </body>
</html>
