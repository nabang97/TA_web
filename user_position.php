<?php
 include('CheckLoc.php');
 ?>


    <!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.4.0.min.js" charset="utf-8"></script>
    <script src="js/script.js"></script>
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
    <script src="js/script.js" charset="utf-8"></script>
  </head>
  <body>
    <div id="map"></div>
    <div id="legend">
      <div class="container">
          hiii
      </div>
    </div>
    <script>
      var legendstatus = false;
      var actionlegend ="<?php echo $actionlegend?>";
      var map, marker;
      var lat = <?php echo $lat ?>;
      var lng = <?php echo $lng ?>;
      function initMap() {
        var latLng = new google.maps.LatLng(lat, lng);
        map = new google.maps.Map(document.getElementById('map'), {
          center: latLng,
          zoom: 13,
          disableDefaultUI: true,

        });
        marker = new google.maps.Marker({
					position: latLng,
					title: 'Your Position',
					map: map
				});
        marker.info = new google.maps.InfoWindow({
          content: '<center><a>Your Position</a></center>',
          pixelOffset: new google.maps.Size(0, -1)
            });
        marker.info.open(map, marker)
        // map.data.LoadGeojson('https://gis-kotogadang.herokuapp.com/dataumkm.php');

        var batasnagari, houselayer, msmelayer, educationlayer, officelayer,worshiplayer;

        setLayerJorong();
        //LoadGeoJorong(jorong,server+'mobile/jorong.php');
        LoadGeoBangunan(houselayer,'red',server+'mobile/datarumah.php');
        LoadGeoBangunan(msmelayer,'purple',server+'mobile/dataumkm.php');
        LoadGeoBangunan(educationlayer,'blue',server+'mobile/datapendidikan.php');
        LoadGeoBangunan(officelayer,'brown',server+'mobile/datakantor.php');
        LoadGeoBangunan(worshiplayer,'green',server+'mobile/datat4ibadah.php');
        LoadGeoBangunan(batasnagari,'black',server+'mobile/batasnagari.php');


        if(actionlegend){
          if(actionlegend == "true"){
            legendstatus = true;
          }
          else{
          legendstatus = false;
          }
        }else{
          legendstatus = false;
        }
        console.log(legendstatus);
        ShowLegend(legendstatus);
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE&callback=initMap"
    async defer></script>

  </body>
</html>
