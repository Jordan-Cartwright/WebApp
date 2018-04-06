<?php
	require_once("functions.php");
	$id = file_get_contents('php://input');
	$mysqli = db_connect();				
	$mysqli->query("DELETE FROM Users8675309 WHERE username='$id'");
	//echo $mysqli->error;

	$mysqli->close();
	
	echo "u".$id;
?>