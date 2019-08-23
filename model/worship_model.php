<?php
//require '../mobile/koneksi.php';


  $model= $_GET["model"];
  $query = "SELECT worship_building_id, name_of_worship_building, ST_X(ST_Centroid(geom)) AS longitude, ST_Y(ST_CENTROID(geom)) AS latitude
					FROM worship_building
					WHERE model_id = '$model' ORDER BY worship_building_id";

  $result = pg_query($query);
  while ($row = pg_fetch_array($result)) {
       $id = $row['worship_building_id'];
       $nama = $row['name_of_worship_building'];
       $marker = 'img/musajik.png';
       $longitude = $row['longitude'];
       $latitude = $row['latitude'];
       $dataarray[] = array('id' => $id, 'name'=>$nama, 'marker'=> $marker, 'longitude' => $longitude, 'latitude' => $latitude);
  }

?>
