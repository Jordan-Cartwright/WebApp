<?php
require_once("functions.php");

session_start();
if ($_SESSION['authenticated'] != true || $_SESSION['admin'] != "false") {
    header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

print_html_header("View Questions");

$mysqli = db_connect();
print_question_table($mysqli);
echo '<a href="insert_question.php" class="btn btn-primary">Make a new Question</a>';
print_html_footer();
?>
