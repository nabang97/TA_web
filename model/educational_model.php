<?php
//require '../mobile/koneksi.php';


  $model= $_GET["model"];
  $query = "SELECT educational_building_id, name_of_educational_building, ST_X(ST_Centroid(geom)) AS longitude, ST_Y(ST_CENTROID(geom)) AS latitude
					FROM educational_building
					WHERE model_id = '$model' ORDER BY educational_building_id";

  $result = pg_query($query);
  while ($row = pg_fetch_array($result)) {
       $id = $row['educational_building_id'];
       $nama = $row['name_of_educational_building'];
       $marker = 'img/sekolah.png';
       $longitude = $row['longitude'];
       $latitude = $row['latitude'];
       $dataarray[] = array('id' => $id, 'name'=>$nama, 'marker'=> $marker, 'longitude' => $longitude, 'latitude' => $latitude);
  }

?>
