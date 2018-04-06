<!DOCTYPE html>
<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <title>Item Ranking</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" >
	  <link rel="stylesheet" href="style.css">
	</head>
	<body>


<?php

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

	// Make a table
	echo '<table border="1">';
	echo '<tr>';
  echo '<td>Row>Column</td>';

  // Sort each row from highest to lowest
	arsort($row);
	  
  // Iterate over columns	to print keys
  foreach ($row as $colkey=>$value) {
  	echo '<td>'.$colkey.'</td>';
  }
  
	echo '</tr>';
	
	// Print the row key
	echo '<tr>';
	echo '<td>'.$rowkey.'</td>';

	// Iterate over rows to print values
  foreach ($row as $colkey=>$value) {
  	echo '<td>'.$value.'</td>';
  }
  
  // Finish up the table
	echo '</tr>';	
	echo '</table>';
	echo '<hr>';		
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

// Print the scores
echo '<ol>';
foreach ($scores as $key=>$value) {
		echo '<li>'.$key." score is ". $value . '</li>';
}
echo '</ol>';


echo json_encode($scores);

?>

		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
	</body>
</html>