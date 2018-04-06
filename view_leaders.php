<?php
require_once("functions.php");

session_start();
if ($_SESSION['authenticated'] != true) {
    header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

print_html_header("View Leader Board");

$mysqli = db_connect();

print_leaders_table($mysqli);

print_html_footer();
?>