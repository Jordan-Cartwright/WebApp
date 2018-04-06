<?php
session_start();
require_once("functions.php");



if ($_SESSION['authenticated'] != true) {
    header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

print_html_header("Play Trivia");

// Start State
if (!$_SESSION['question_num'] || !$_POST || $_POST['action']=="Play Again") {

	$_SESSION['question_num'] = 1;
	$_SESSION['points'] = 0;

	$mysqli = db_connect();
	$result = $mysqli->query("SELECT * FROM Questions8675309 ORDER BY RAND() LIMIT 10");

	echo $mysqli->error;
	$questions_array = array();

	while ($row = $result->fetch_row()) {

		array_push($questions_array, $row);
	}

	$result->close();
	$mysqli->close();
	//var_dump($questions_array);
	$_SESSION['questions'] = $questions_array;	


	echo '
		<p>Welcome to trivia '.$_SESSION['username'].'!</p>
		<p>Each game is 10 questions and for every question you get correct, you recieve 10 points.</p>
		<p>Good luck!</p>
		<form method="post" action="play_trivia.php">
			<input type="submit" class="btn btn-lg btn-block btn-primary" name="action" value="Start">
		</form>';

}

else if ($_SESSION['question_num'] > 10){
	$mysqli = db_connect();
    $username = $_SESSION['username'];
	$sql = "SELECT games, points FROM Users8675309 WHERE username='$username'";
	$result = $mysqli->query($sql);
	$row = $result->fetch_row();
	$games = $row[0] + 1;
	$points = $row[1] + $_SESSION['points'];
	
	$sql = "UPDATE Users8675309 SET games=$games, points=$points WHERE username='$username'";
	$mysqli->query($sql);
    //close connections to the db
    $result->close();
    $mysqli->close();
    $curPoints = $_SESSION['points'];
    if($curPoints > 95) {
        echo '
		<div class="alert alert-success text-center" role="alert">
			<p><strong>Congratulations</strong> you finished with a perfect score!</p>
		</div>';
    }
    else if($curPoints >= 70 && $curPoints < 100) {
        echo '
        <div class="alert alert-success text-center" role="alert">
            <p><strong>Congratulations</strong> you did a great job!</p>
        </div>';
    }
    else if($curPoints >= 50 && $curPoints < 70) {
        echo '
        <div class="alert alert-warning text-center" role="alert">
            <p><strong>Good Job</strong> but it looks like there\'s room for improvement!</p>
            <p>Better luck next time!</p>
        </div>';
    }
    else if($curPoints < 50) {
        echo '
        <div class="alert alert-alert text-center" role="alert">
            <p><strong>uh-oh</strong> it looks like you\'ve had a difficult time!</p>
            <p>Better study up on your trivia!</p>
        </div>
        ';
    }
    echo '
    <div class="text-center">
        <p>You scored a total '.$curPoints.' out of 100 points</p>
    </div>
    <div class="text-center">
        <div class="btn-group text-center">
            <a class="btn btn-lg btn-primary" href="view_leaders.php">Leaderboards</a><br>
            <a class="btn btn-lg btn-primary" href="play_trivia.php">Play Again</a><br>
            <a class="btn btn-lg btn-primary" href="home.php"> Home </a>
        </div>
    </div>
        
    
    ';
}

// Display State
else if ($_POST['action']=="Start" || $_POST['action']=="Next Question") {
	$question_index = $_SESSION['question_num'] - 1;
	$current_question =  $_SESSION['questions'][ $question_index ];

	$q = $current_question[1];
	$c1 = $current_question[2];
	$c2 = $current_question[3];
	$c3 = $current_question[4];
	$c4 = $current_question[5];

	$_SESSION['answer'] =  $current_question[6];


		echo '
        <h3>Question '.$_SESSION['question_num'].'</h3>
        <div class="questionsForm">

        <div class="row">
            <div class="col-sm-12">
                <div class="card text-center">
                    <h4 class="card-header">'.$q.'</h4>
                    <div class="card-block">

                        <form method="post" action="play_trivia.php">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <label class="btn btn-primary btn-lg btn-block">
                                            <input class="btn btn-primary" type="radio" name="answer" value="1">
                                            '.$c1.'
                                        </label>
                                    </li>
                                    <li class="list-group-item">
                                        <label class="btn btn-primary btn-lg btn-block">
                                            <input class="btn btn-primary" type="radio" name="answer" value="2">
                                            '.$c2.'
                                        </label>
                                    </li>
                                    <li class="list-group-item">
                                        <label class="btn btn-primary btn-lg btn-block">
                                            <input class="btn btn-primary" type="radio" name="answer" value="3">
                                            '.$c3.'
                                        </label>
                                    </li>
                                    <li class="list-group-item">
                                        <label class="btn btn-primary btn-lg btn-block">
                                            <input class="btn btn-primary" type="radio" name="answer" value="4">
                                            '.$c4.'
                                        </label>
                                    </li>
                                    <li class="list-group-item">
                                        <input class="btn btn-success btn-lg btn-block" type="submit" name="action" value="Submit">
                                    </li>
                                </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        </div>';

}

// Feedback State
else if ($_POST['action']=="Submit"){
	
	$_SESSION['question_num']++;
	
	if($_POST['answer']==$_SESSION['answer']){

		$_SESSION['points'] += 10;

		echo '

		<div class="alert alert-success text-center" role="alert">
			<p><strong>You are Correct</strong></p>
            <p>You scored 10 points!</p>
		</div>';

	}

	else{
        //get the question answers for the previous question
        $question_index = $_SESSION['question_num'] - 2;
        $current_question =  $_SESSION['questions'][ $question_index ];
        $c1 = $current_question[2];
        $c2 = $current_question[3];
        $c3 = $current_question[4];
        $c4 = $current_question[5];
        
        $ans = '';
        $myAns = '';
        
        //grab the text from that answer
        if($_POST['answer'] == 1) {
            $myAns = ''.$c1.'';
        }
        else if($_POST['answer'] == 2) {
            $myAns = ''.$c2.'';
        }
        else if($_POST['answer'] == 3) {
            $myAns = ''.$c3.'';
        }
        else if($_POST['answer'] == 4) {
            $myAns = ''.$c4.'';
        }
        
        //print out the statements 
        if($_SESSION['answer'] == 1) {
            $ans = '<p>The correct answer is '.$c1.' but you selected '.$myAns.'</p>';
        }
        else if($_SESSION['answer'] == 2) {
            $ans = '<p>The correct answer is '.$c2.' but you selected '.$myAns.'</p>';
        }
        else if($_SESSION['answer'] == 3) {
            $ans = '<p>The correct answer is '.$c3.' but you selected '.$myAns.'</p>';
        }
        else if($_SESSION['answer'] == 4) {
            $ans = '<p>The correct answer is '.$c4.' but you selected '.$myAns.'</p>';
        }

		echo '
		<div class="alert alert-danger text-center" role="alert">
			<p><strong>Sorry you are Incorrect!</strong></p>
            <p>You scored no points</p>'
            .$ans.'
		</div>';
	}

		echo '
        <div class="text-center">
			<p>You have '.$_SESSION['points'].' points!</p>
            <form method="post" action="play_trivia.php">
                <input class="btn btn-lg btn-block btn-primary" type="submit" name="action" value="Next Question">
            </form>
		</div>
		';

		

}

print_html_footer();

?>



