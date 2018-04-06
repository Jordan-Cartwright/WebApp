<?php
	require_once("functions.php");

    if ($_SESSION['authenticated'] != true) {
        header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
        die();
    }

	$mysqli = db_connect();
	$sql = "SELECT question, choice1, choice2, choice3, choice4 FROM Questions16384 ORDER BY RAND()";
	$result = $mysqli->query($sql);
	$row = $result->fetch_row();
	$q = $row[0];
	$c1 = $row[1];
	$c2 = $row[2];
	$c3 = $row[3];
	$c4 = $row[4];
	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Question</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >
  </head>
  <body>
	<form method="post" action="get_question.php">
		
		<label><? echo $q ?><br>
		</label><br>
		
		<label>
		<? echo $c1 ?>
		<input type="radio" name="answer" value="1">
		</label><br>
		
		<label>
		<? echo $c2 ?>
		<input type="radio" name="answer" value="2">
		</label><br>
		
		<label>
		<? echo $c3 ?>
		<input type="radio" name="answer" value="3">
		</label><br>
		
		<label>
		<? echo $c4 ?>
		<input type="radio" name="answer" value="4">
		</label><br>
		
		<input type="submit" name="action" value="Next">
	</form>
  
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
  </body>
</html>