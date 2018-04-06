<?php

if($_GET['key']!="8675309") {
	die("Access denied");
}

$sql = "INSERT INTO Users8675309 VALUES 
('overlord', '".'$2y$10$rGSvwmvurEuoNgei6WSCCOs9A/WvXx0mwGGYrXIEJV4zlQo8vmGTq'."', 'admin', '0', '0.0')";

require_once("../functions.php");

$mysqli = db_connect();	
$mysqli->query($sql);
$mysqli->close();

?>