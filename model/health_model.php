<?php
//require '../mobile/koneksi.php';


  $model= $_GET["model"];
  $query = "SELECT health_building_id, name_of_health_building, ST_X(ST_Centroid(geom)) AS longitude, ST_Y(ST_CENTROID(geom)) AS latitude
					FROM health_building
					WHERE model_id = '$model' ORDER BY health_building_id";

  $result = pg_query($query);
  while ($row = pg_fetch_array($result)) {
       $id = $row['health_building_id'];
       $nama = $row['name_of_health_building'];
       $marker = 'img/kesehatan.png';
       $longitude = $row['longitude'];
       $latitude = $row['latitude'];
       $dataarray[] = array('id' => $id, 'name'=>$nama, 'marker'=> $marker, 'longitude' => $longitude, 'latitude' => $latitude);
  }

?>
