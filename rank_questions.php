<?php
session_start();
require_once("functions.php");



if ($_SESSION['authenticated'] != true) {
    header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

print_html_header("Rank Questions");

//Start State
if (!$_POST) {

    echo '
        <p>Here you can rank the questions in the game.</p>
        <p>2 questions will be displayed to you and your job is select the better question!</p>
        <form method="post" action="rank_questions.php">
            <input type="submit" class="btn btn-lg btn-primary" name="action" value="Start">
        </form>';
}

// Display State
else if ($_POST['action']=="Start" || $_POST['action']=="Rate") {
    $mysqli = db_connect();
    $result = $mysqli->query("SELECT * FROM Questions8675309 ORDER BY RAND() LIMIT 2");

    echo $mysqli->error;
    $questions_array = array();
    unset($questions_array); 
    $questions_array = array();

    while ($row = $result->fetch_row()) {

        array_push($questions_array, $row);
    }

    $result->close();
    $mysqli->close();
    
    $_SESSION['questions'] = $questions_array;	
	$current_question1 =  $_SESSION['questions'][0];
	$current_question2 =  $_SESSION['questions'][1];

	$q1ID = $current_question1[0];
	$q1 = $current_question1[1];
	$c11 = $current_question1[2];
	$c12 = $current_question1[3];
	$c13 = $current_question1[4];
	$c14 = $current_question1[5];
    
    $q2ID = $current_question2[0];
    $q2 = $current_question2[1];
	$c21 = $current_question2[2];
	$c22 = $current_question2[3];
	$c23 = $current_question2[4];
	$c24 = $current_question2[5];
    
    
    echo '
        <div class="card-deck">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">'.$q1.'</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">'.$c11.'</li>
                    <li class="list-group-item">'.$c12.'</li>
                    <li class="list-group-item">'.$c13.'</li>
                    <li class="list-group-item">'.$c14.'</li>
                </ul>
                <div class="card-block">
                    <form method="post" action="rank_questions.php">
                        <input type="submit" class="btn btn-block btn-primary" name="action" value="Rate">
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">'.$q2.'</h4>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">'.$c21.'</li>
                    <li class="list-group-item">'.$c22.'</li>
                    <li class="list-group-item">'.$c23.'</li>
                    <li class="list-group-item">'.$c24.'</li>
                </ul>
                <div class="card-block">
                    <form method="post" action="rank_questions.php">
                        <input type="submit" class="btn btn-block btn-primary" name="action" value="Rate">
                    </form>
                </div>
            </div>
        </div>
        
        <script>
            var selectedArray = document.querySelectorAll("input[type=submit]");

            btnOne = selectedArray[0];
            btnTwo = selectedArray[1];
            itemOne = '.$q1ID.';
            itemTwo = '.$q2ID.';
            
            btnOne.addEventListener("click", function() {
                        recordRanking(itemOne, itemTwo);
                    });	

            btnTwo.addEventListener("click", function() {
                        recordRanking(itemTwo, itemOne);
                    });
        </script>
        
        ';

}

print_html_footer();

?>