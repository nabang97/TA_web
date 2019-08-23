<?php

	$host = "ec2-23-21-186-85.compute-1.amazonaws.com";
	$user = "uuevxbdhtfjvch";
	$pass = "22d313d048556fd251ed84b197a84bc9b43d97987e9ee302575e0c429160f6ec";
	$port = "5432";
	$dbname = "d7n6clvsu5ubsn";
	$conn = pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$pass) or die("Gagal");

?>
