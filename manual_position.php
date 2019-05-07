<?php
 include('CheckLoc.php');
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<title></title>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE"></script>
		<script src="js/script.js" charset="utf-8"></script>
		<link rel="stylesheet" href="css/style.css">
		<script type="text/javascript">
			var geocoder = new google.maps.Geocoder();
			var lat = <?php echo $lat ?>;
      var lng = <?php echo $lng ?>;
			var legendstatus = false;
      var actionlegend ="<?php echo $actionlegend?>";
			var map,marker;
			function geocodePosition(pos,infowindow) {
				geocoder.geocode({
					latLng: pos
				}, function(responses) {
					if (responses && responses.length > 0) {
						infowindow.setContent(responses[0].formatted_address);
						updateMarkerAddress(responses[0].formatted_address);

					} else {
						updateMarkerAddress('Cannot determine address at this location.');
					}
				});
			}

			function updateMarkerStatus(str) {
				// document.getElementById('markerStatus').innerHTML = str;
				//B4A.CallSub('Marker_Dragging', true, str);
			}

			function updateMarkerPosition(latLng) {
				// document.getElementById('info').innerHTML = [
				// 	latLng.lat(),
				// 	latLng.lng()
				// ].join(', ');
			}

			function updateMarkerAddress(str) {
				// document.getElementById('address').innerHTML = str;
				B4A.CallSub('Marker_Address', true, str);
				marker.info.setContent(str);
			}

			function initialize() {
				var latLng = new google.maps.LatLng(lat, lng);
			 map = new google.maps.Map(document.getElementById('mapCanvas'), {
					zoom: 13,
					center: latLng,
					disableDefaultUI: true
				});
				marker = new google.maps.Marker({
					position: latLng,
					title: 'Your Position',
					map: map,
					draggable: true
				});
				MarkerInfo(marker,'Drag Me');

				var batasnagari, houselayer, msmelayer, educationlayer, officelayer,worshiplayer;
				LoadGeoBangunan(batasnagari,'black',server+'mobile/batasnagari.php');
				LoadGeoBangunan(houselayer,'red',server+'mobile/datarumah.php');
				LoadGeoBangunan(msmelayer,'yellow',server+'mobile/dataumkm.php');
				LoadGeoBangunan(educationlayer,'blue',server+'mobile/datapendidikan.php');
				LoadGeoBangunan(officelayer,'brown',server+'mobile/datakantor.php');
				LoadGeoBangunan(worshiplayer,'green',server+'mobile/datat4ibadah.php');
				// var layernya = new google.maps.Data();
        //                    layernya.loadGeoJson('https://gis-kotogadang.herokuapp.com/batasnagari.php');
        //                    layernya.setMap(map);

				// Update current position info.
				updateMarkerPosition(latLng);
				geocodePosition(latLng);



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



				// Add dragging event listeners.
				google.maps.event.addListener(marker, 'dragstart', function() {
					updateMarkerAddress('Dragging...');
				});

				google.maps.event.addListener(marker, 'drag', function() {
					updateMarkerStatus('Dragging...');
					updateMarkerPosition(marker.getPosition());
					marker.info.setContent('Dragging...');
				});

				google.maps.event.addListener(marker, 'dragend', function() {
					updateMarkerStatus('Drag ended');
					geocodePosition(marker.getPosition(),marker.info);
					//	call the B4A Sub Marker_DragEnd passing the Marker's new position
					B4A.CallSub('Marker_DragEnd', true, marker.getPosition().lat(), marker.getPosition().lng());
					//B4A.CallSub('Marker_DragEnd', true, marker.getPosition().lat(), marker.getPosition().lng());
				});
			}

			//document.getElementById("close").onclick = function() {document.getElementById("legend").style.display = 'none';};
			// };
			// Onload handler to fire off the app.
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
		<style>
		/* Optional: Makes the sample page fill the window. */
		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
			#mapCanvas {
				height: 100%;
			}
			#infoPanel {
				margin-left: 10px;
			}
			#infoPanel div {
				margin-bottom: 5px;
			}
		</style>
	</head>
	<body>

		<div id="mapCanvas"></div>
		<div id="legend">
      <div class="container" >
        <a id="close" onclick="CloseLegend()">X</a>
      </div>
    </div>
		<!-- <div id="infoPanel">
			<b>Marker status:</b>
			<div id="markerStatus"><i>Click and drag the marker.</i></div>
			<b>Current position:</b>
			<div id="info"></div>
			<b>Closest matching address:</b>
			<div id="address"></div>
		</div> -->
	</body>
</html>
