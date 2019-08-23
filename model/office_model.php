<?php
//require '../mobile/koneksi.php';


  $model= $_GET["model"];
  $query = "SELECT office_building_id, name_of_office_building, ST_X(ST_Centroid(geom)) AS longitude, ST_Y(ST_CENTROID(geom)) AS latitude
					FROM office_building
					WHERE model_id = '$model' ORDER BY office_building_id";

  $result = pg_query($query);
  while ($row = pg_fetch_array($result)) {
       $id = $row['office_building_id'];
       $nama = $row['name_of_office_building'];
       $marker = 'img/kantor.png';
       $longitude = $row['longitude'];
       $latitude = $row['latitude'];
       $dataarray[] = array('id' => $id, 'name'=>$nama, 'marker'=> $marker, 'longitude' => $longitude, 'latitude' => $latitude);
  }

?>
