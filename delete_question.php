<?php
require_once("functions.php");

session_start();
if ($_SESSION['authenticated'] != true || $_SESSION['admin'] != "false") {
    header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

print_html_header("Delete Question");


//  Only process if $_GET is not empty and an id is present in the URL
if (empty($_GET) == false && $_GET['id'] != "") {
	$id = $_GET['id'];
	$mysqli = db_connect();				
	$mysqli->query("DELETE FROM Questions8675309 WHERE id=$id");
	$mysqli->close();
}

// Always print the list table of questions
$mysqli = db_connect();				
$result = $mysqli->query("SELECT question, choice1, choice2, choice3, choice4, answer, id FROM Questions8675309");


while ($row = $result->fetch_array()) {
	$ans = '<ul class="list-group list-group-flush">';
	  for($i = 1; $i <= 4; $i++) {
	  if($i != $row[5]) {
			$ans .= '<li class="list-group-item ">'.$row[$i].'</li>';
		}
		else {
			  $ans .= '<li class="list-group-item active">'.$row[$i].'</li>';
		  }
	  }
	  echo '
			<div class="card">
			  <div class="card-block">
				<h4 class="card-title">'.$row[0].'</h4>
			  </div>'.
			  $ans . '</ul>
			  <div class="card-block">';
				echo '<input type="button" class="btn btn-danger btn-delete" id="q'.$row[6].'" value="Delete">'. '
			  </div>
			</div>
		';
}
$result->close();
$mysqli->close();

print_html_footer();
?>