//Set up Server URL
var server = 'https://gisbuilding.herokuapp.com/';
var njorong = 0; var digitjorong = [];

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
      directionsDisplay.setPanel(document.getElementById('directionsPanel'));

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
           layername.loadGeoJson(url,null,function(features){
          //    console.log("heii");
          //    features.forEach(function(feature) {
          //     console.log('properties are: ');
          //     feature.forEachProperty(function(value,property) {
          //         console.log(property,':',value);
          //     });
          // });
           });
           layername.setMap(map);
}
function setLayerJorong(){
  var url = server+'mobile/jorong.php';
  console.log(url);
  $.ajax({url: url, data: "", dataType: 'json', success: function(arrays){
    for (i = 0; i < arrays.features.length; i++) {
        var data = arrays.features[i];
        var arrayGeometries = data.geometry.coordinates;
        var jenis = data.jenis;
        var p2 = data.properties.nama;
        var p3 = 'Jorong: ' + p2;

        var idTitik = 0;
        var hitungTitik = [];
        while (idTitik < arrayGeometries[0][0].length) {
          var aa = arrayGeometries[0][0][idTitik][0];
          var bb = arrayGeometries[0][0][idTitik][1];
          hitungTitik[idTitik] = {
            lat: bb,
            lng: aa
          };
          idTitik += 1;
        }
        if (data.properties.id == "KG") {
          var warna = 'yellow';
        } else if (data.properties.id == "GT") {
          var warna = 'green';
        } else if (data.properties.id == "SJ") {
          var warna = '#478dff';
        }

        digitjorong[njorong] = new google.maps.Polygon({
         paths: hitungTitik,
         strokeColor: 'gray',
         strokeOpacity: 0.6,
         strokeWeight: 1.5,
         fillColor: warna,
         fillOpacity: 0.2,
         zIndex: 0,
         clickable: false
       });
       digitjorong[njorong].setMap(map);
       njorong = njorong + 1;
      }//end for

  }});//end ajax
}
function LoadGeoJorong(layername,url){
var warna;
var njorong = 0;
layername = new google.maps.Data();
layername.loadGeoJson(url,null,function(features){
 console.log("heii");
 console.log(features.length);


 features.forEach(function(feature){
   console.log(feature.getGeometry().getType());
   console.log(feature.getGeometry());
   var tesaja = feature.getGeometry('coordinates').getArray();
   console.log(tesaja[0].getArray());
   var object = tesaja[0].getArray();
   for (var variable in object) {
     if (object.hasOwnProperty(variable)) {
       var value = object[variable];
       console.log(value);
       console.log(value.getArray());
       valuetwo =value.getArray();
     }
   }
   //console.log(teslagi.[0].getArray());
      feature.forEachProperty(function(value,property) {
        console.log(property,':',value);
        if (value == "KG") {
          var warna = 'yellow';

        } else if (value == "GT") {
          var warna = 'green';

        } else if (value == "SJ") {
          var warna = '#478dff';
        }
      });
  });
});
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
