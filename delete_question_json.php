<?php
	require_once("functions.php");
	$id = file_get_contents('php://input');
	$mysqli = db_connect();				
	$mysqli->query("DELETE FROM Questions8675309 WHERE id=$id");
	$mysqli->close();
	echo "q".$id;
?>