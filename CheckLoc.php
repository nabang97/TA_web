<?php
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

if (isset($_GET['legend'])) {
  if ($_GET['legend'] != "") {
    $actionlegend = $_GET['legend'];
  }else {
    $actionlegend = "null";
  }
}else {
  $actionlegend = "null";
}
 ?>
