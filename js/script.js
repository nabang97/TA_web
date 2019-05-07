//Set up Server URL
var server = 'https://d809bd8c.ngrok.io/gisbuilding_mobile/';

function callRoute(start, end, color, endmarker) {
  var rendererOptions = {
    suppressMarkers : true,
    // markerOptions:{ //ganti icon marker destination
    //   icon: { url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png" }
    // },
    polylineOptions: { //ganti warna rute
      strokeColor: color
    }
  }
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

    directionsService.route({
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.DRIVING
      },
      function (response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
          var distance = response.routes[0].legs[0].distance.value;
          console.log(distance+" meter");
          var km = distance/ 1000;
          console.log(km.toFixed(1) + " km");

          endmarker.info = new google.maps.InfoWindow({
            content: '<center><a>Destination<br>'+km.toFixed(1) + " km"+'</a></center>',
            pixelOffset: new google.maps.Size(0, -1)
              });
          endmarker.info.open(map, endmarker)
          // var step =Math.floor(response.routes[0].legs[0].steps.length / 2);
          // var infowindow2 = new google.maps.InfoWindow();
          // infowindow2.setContent(response.routes[0].legs[0].steps[step].distance.text + "<br>" + response.routes[0].legs[0].steps[step].duration.text + " ");
          // infowindow2.setPosition(response.routes[0].legs[0].steps[step].end_location);
          // infowindow2.open(map);
        } else {
          window.alert('Directions request failed due to ' + status);
        }
      }
    );

    directionsDisplay.setMap(map);
    //directionsDisplay.setOptions( { suppressMarkers: true } );
    map.setZoom(16);
}

function ShowLegend(str){
  if (str){
    document.getElementById('legend').style.display = 'block';
  }else{
    document.getElementById('legend').style.display = 'none';
  }
}

function LoadGeoBangunan(layername,color,url){
layername = new google.maps.Data();
            layername.setStyle({
          fillColor: color,
          strokeColor: color,
          strokeWeight: 1
        });
           layername.loadGeoJson(url);
           layername.setMap(map);
}

function MarkerInfo(marker, info){
  marker.info = new google.maps.InfoWindow({
        content: '<center><a>'+info+'!</a></center>',
        pixelOffset: new google.maps.Size(0, -1)
          });
  marker.info.open(map, marker)
}

function CloseLegend(){
  document.getElementById("legend").style.display= 'none';
  legendstatus = false;
  B4A.CallSub('Legend_Status', true, legendstatus)
}
