<?php
if($_GET['key']!="8675309") {
	die("Access denied");
}

require_once("../functions.php");

$mysqli = db_connect();		

$sql = "DROP TABLE IF EXISTS Questions8675309";

$mysqli->query($sql);

$sql = "CREATE TABLE Questions8675309 ( 
          id INT NOT NULL AUTO_INCREMENT,
          question VARCHAR(1024) NOT NULL,
          choice1 VARCHAR(1024) NOT NULL,
          choice2 VARCHAR(1024) NOT NULL,
          choice3 VARCHAR(1024) NOT NULL,
          choice4 VARCHAR(1024) NOT NULL,
          answer INT NOT NULL, 
          PRIMARY KEY (`id`) 
          )";

$mysqli->query($sql);
$mysqli->close();
?>