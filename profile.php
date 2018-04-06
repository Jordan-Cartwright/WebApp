<?php
require_once("functions.php");

session_start();
if ($_SESSION['authenticated'] != true) {
    header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

$username = $_SESSION['username'];
// Connect to database and get stored stats
$mysqli = db_connect();		
$result = $mysqli->query("SELECT points, games FROM Users8675309 WHERE username='$username'");
$row = $result->fetch_row();
$curScore = $row[0];
$numGames = $row[1];


print_html_header("Profile");

$mysqli->close();

print_html_footer();
?>