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
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE">
		</script>
    <?php
      $lat = $_GET["lat"];    // Isi yang dicari
      $lng = $_GET["lng"];
      $rad = $_GET["rad"];
     ?>
		<script type="text/javascript">
		var map;
		var lat = <?php echo $lat ?>;
		var lng = <?php echo $lng ?>;
		var rad = <?php echo $rad ?>;
    var markers = [];
				function init(){
					console.log("init jalan");
					var latlng = new google.maps.LatLng(lat, lng);

					var myOptions = {
			      zoom:10, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP };
			      map = new google.maps.Map(document.getElementById('map'), myOptions);

			    var marker = new google.maps.Marker({ position: latlng,map: map,title: '', clickable:false, icon:''});
			    marker.info = new google.maps.InfoWindow({
			      content: '<center><a>Your Position</a></center>',
			      pixelOffset: new google.maps.Size(0, -1)
			        });
			    marker.info.open(map, marker)

					var circle = new google.maps.Circle({
			      center: latlng,
			      radius: <?php echo $rad ?>,
			      map: map,
			      strokeColor: "blue",
			      strokeOpacity: 0.5,
			      strokeWeight: 1,
			      fillColor: "blue",
			      fillOpacity: 0.35
			    });

          var url = server+'/Msme/search_radius.php?lat='+lat+'&lng='+lng+'&rad='+rad+'';
          console.log(url);
          $.ajax({url: url, data: "", dataType: 'json', success: function(rows){
              for (var i in rows){
                var row = rows[i];
                var id = row.id;
                var marker = new google.maps.Marker({
                   position: {lat: parseFloat(row.latitude), lng:  parseFloat(row.longitude)},
                   map: map,
                   title: row.name,
                   icon:{ url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png" }
                  });
                 markers.push(marker);
                 console.log(row);
                 console.log(id);
              }//end for

          }});//end ajax

				}
		</script>
  </head>
  <body onload="init()">
    <div id="map"></div>

    <script src="../js/script.js"></script>
		<script src="../js/jquery-3.4.0.min.js" charset="utf-8"></script>
		<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE&callback=initMap"
		async defer></script> -->
  </body>
</html>
