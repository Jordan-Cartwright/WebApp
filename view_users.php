<?php
require_once("functions.php");

session_start();

if ($_SESSION['authenticated'] != true || $_SESSION['admin'] != "false") {
    header("https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

print_html_header("View Users");

$mysqli = db_connect();

print_users_table($mysqli);

print_html_Userfooter();
?>