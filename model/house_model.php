<?php
//require '../mobile/koneksi.php';

  $model= $_GET["model"];
  $query = "SELECT house_building_id, C.name As name, ST_X(ST_Centroid(geom)) AS longitude, ST_Y(ST_CENTROID(geom)) AS latitude
					FROM house_building
          JOIN citizen As C ON owner_id=C.national_identity_number
					WHERE model_id = '$model' ORDER BY house_building_id";

  $result = pg_query($query);
  while ($row = pg_fetch_array($result)) {
       $id = $row['house_building_id'];
       $nama = $row['name'];
       $marker = 'img/home.png';
       $longitude = $row['longitude'];
       $latitude = $row['latitude'];
       $dataarray[] = array('id' => $id,'name'=>$nama, 'marker'=> $marker, 'longitude' => $longitude, 'latitude' => $latitude);
  }
  
?>
