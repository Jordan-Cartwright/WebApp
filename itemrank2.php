<?php
require_once("functions.php");

session_start();
if ($_SESSION['authenticated'] != true || $_SESSION['admin'] != "false") {
    header("https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

print_html_header("Ranked Questions");
echo '<p>Questions are displayed from lowest ranked to highest rank</p>';


///////////////////////////////////////////////////////////////////////////
// 1. How to get data from a file
$dataString = file_get_contents("rankings.txt");
//var_dump($dataString);

// 2. How to convert CSV data to array
$dataArray = explode(',', $dataString);
//var_dump($dataArray);

// 3. How to create empty arrays
$items = array();
$matrix = array();

// 4. How to iterate over arrays
foreach ($dataArray as $rank) {

	// Break each item into item pair
	$pair = explode('>', $rank);
	
	// If the pair of items are not blank
	if ($pair[0] != "" && $pair[1] != "") {
	
		// Add each item to the items array
		$items[$pair[0]] = true;
		$items[$pair[1]] = true;
		
		// Add the pair to the adjacency matrix
		$matrix[$pair[0]][$pair[1]]++;
	}
}

// 5. How to sort associate array by index/key
ksort($matrix);

// 5. Iterate over outer array assoicative array, i.e., the array of rows
foreach ($matrix as $rowkey=>$row) {
    // Sort each row from highest to lowest
    arsort($row);		
}

// Limit on the depth of recursion
$limit = 3;

// Recursive "ranking" algorithm 
function getsum($m, $name, $level) {

		// Use the global variable so they don't have to be copied		
		global $not_visited;
		global $matrix;
		global $limit;
		
		// No point in going too deep into the tree
		if ($level >= $limit) {
			return 0;
		}	
		else {		
		  // Mark self as visited to prevent loops
			$not_visited[$name] = false;
		
			// Calculate the sum of the "wins" for $name at current level
			$sum = 0;	
		
			// Iterate over row $m
			foreach ($m as $key=>$value) {
				
				// To prevent loops to other visited nodes
				if ($not_visited[$key]) {
				
					// Call get sum on all of items we "beat"
					$sum += $value + getsum($matrix[$key], $key, $level+1)/2 ;				
				}
			}

			// Unmark self as visited
			$not_visited[$name] = true;
			
			return $sum;
		}

}

// For storing each item's score
$scores = array();

//Iterate over items to get score
foreach ($items as $key=>$value) {
	$not_visited = $items;
	$score = getsum($matrix[$key], $key, 0);
	$scores[$key] = $score;
}

// Sort the scores
//sort in accending order
asort($scores);

///////////////////////////////////////////////////////////////////////////


//  Only process if $_GET is not empty and an id is present in the URL
if (empty($_GET) == false && $_GET['id'] != "") {
	$id = $_GET['id'];
	$mysqli = db_connect();				
	$mysqli->query("DELETE FROM Questions8675309 WHERE id=$id");
	$mysqli->close();
}

// Always print the list table of questions
				
//$result = $mysqli->query("SELECT question, choice1, choice2, choice3, choice4, answer, id FROM Questions8675309");

$ranked = 1;
foreach ($scores as $key=>$id) {
    $mysqli = db_connect();
    $result = $mysqli->query("SELECT question, choice1, choice2, choice3, choice4, answer, id FROM Questions8675309 WHERE id='$key'");
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
                    <p class="lead">Rank: '.$ranked.' ID:'.$row[6].'</p>
                  </div>'.
                  $ans . '</ul>
                  <div class="card-block">';
                    echo '<input type="button" class="btn btn-danger btn-delete" id="q'.$row[6].'" value="Delete">'. '
                  </div>
                </div>
            ';
        $ranked++;
    }
    $result->close();
    $mysqli->close();
}


////////////////////////////////////////////////////////////
// Print the scores
echo '<ol>';
foreach ($scores as $key=>$value) {
		echo '<li>'.$key." score is ". $value . '</li>';
}
echo '</ol>';
////////////////////////////////////////////////////////////
print_html_footer();
?>