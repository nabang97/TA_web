<?php
require '../mobile/koneksi.php';
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
if (isset($_GET["type"])) {

  $jenis = $_GET["type"];

  $querysearch = " SELECT office_building_id, name_of_office_building ,ST_X(ST_Centroid(geom)) AS longitude, ST_Y(ST_CENTROID(geom)) AS latitude
					         FROM office_building
                   WHERE type_of_office = '$jenis' ORDER BY name_of_office_building";

  $hasil = pg_query($querysearch);
  while ($row = pg_fetch_array($hasil)) {
      $id = $row['office_building_id'];
      $name = $row['name_of_office_building'];
      $longitude = $row['longitude'];
      $latitude = $row['latitude'];
      $dataarray[] = array('id' => $id, 'name' => $name, 'longitude' => $longitude, 'latitude' => $latitude);
  }
  if (empty($dataarray)) {
    $datajson = 'null';
  }
  else {
      $datajson = json_encode ($dataarray);
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <script src="../js/jquery-3.4.0.min.js" charset="utf-8"></script>
    <script src="../js/script.js" charset="utf-8"></script>
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
    var latposition = <?php echo $lat ?>;
    var lngposition = <?php echo $lng ?>;
    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -0.3209284, lng: 100.3484996},
        zoom: 13
      });

      var batasnagari, houselayer, msmelayer, educationlayer, officelayer,worshiplayer;

      setLayerJorong();
      LoadGeoBangunan(houselayer,'red',server+'mobile/datarumah.php');
      LoadGeoBangunan(msmelayer,'purple',server+'mobile/dataumkm.php');
      LoadGeoBangunan(educationlayer,'blue',server+'mobile/datapendidikan.php');
      LoadGeoBangunan(officelayer,'brown',server+'mobile/datakantor.php');
      LoadGeoBangunan(worshiplayer,'green',server+'mobile/datat4ibadah.php');
      LoadGeoBangunan(batasnagari,'black',server+'mobile/batasnagari.php');


      var a = <?php echo $datajson; ?>;
      if (a == null) {
        console.log("DATA NGGAK ADA");
      }
      else {
        console.log(a);
        panjang=a.length;
        if (panjang > 0) {
          console.log(a[0]['latitude']);
            for (i=0; i < panjang; i++) {
              var myLatLng = {lat: parseFloat(a[i]['latitude']), lng: parseFloat(a[i]['longitude'])};
              var marker = new google.maps.Marker({
                 position: myLatLng,
                 map: map,
                 title: a[i]['name'],
                 icon:{ url: ""+server+"/img/kantor.png" }
                });

           }
        }
      }

      var markerposition = new google.maps.Marker({
         position: {lat: latposition, lng: lngposition},
         map: map,
         title: "Your Position",
         clickable : false
      });
      markerposition.info = new google.maps.InfoWindow({
       content: '<center><a>Your Position</a></center>',
       pixelOffset: new google.maps.Size(0, -1)
         });
     markerposition.info.open(map, markerposition)

        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE&callback=initMap"
    async defer></script>
    <script src="../js/jquery-3.4.0.min.js" charset="utf-8"></script>
    <script src="../js/script.js" charset="utf-8"></script>
  </body>
</html>
