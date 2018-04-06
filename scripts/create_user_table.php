<?php
if($_GET['key']!="8675309") {
	die("Access denied");
}

require_once("../functions.php");

$mysqli = db_connect();		

$sql = "DROP TABLE IF EXISTS Users8675309";

$mysqli->query($sql);

$sql = "CREATE TABLE Users8675309 ( 
          username VARCHAR(64) NOT NULL, 
          password VARCHAR(64) NULL, 
          usertype VARCHAR(64) NOT NULL DEFAULT 'normal', 
          games INT NOT NULL DEFAULT '0', 
          points FLOAT NOT NULL DEFAULT '0.0', 
          PRIMARY KEY (username) 
          )";

$mysqli->query($sql);
$mysqli->close();
?>
