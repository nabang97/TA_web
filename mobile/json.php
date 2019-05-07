<?php

	//header('content-type: application/json');
	header('content-type: application/json; charset=utf8');
	header("access-control-allow-origin: *");
	include "koneksi.php";
	$query = file_get_contents("php://input");
  $sth = pg_query($query);
	$items = array();
	while($row = pg_fetch_assoc($sth)){
		$items[] = $row;
	}
	print json_encode($items);
?>
