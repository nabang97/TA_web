<?php
// header('content-type: application/json');
// header("access-control-allow-origin: *");
if (isset($_GET['lat']) && isset($_GET['lng'])) {
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

include('Office/data_office.php');
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
          // var layernya = new google.maps.Data();
          //                    layernya.loadGeoJson(a);
          //                    layernya.setMap(map);
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
  				 position: {lat: lat, lng: lng},
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
    <script src="js/jquery-3.4.0.min.js" charset="utf-8"></script>
    <script src="js/script.js"></script>
  </body>
</html>
  </body>
</html>
