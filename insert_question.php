<?php

// Just in case, I want to remember the user
session_start();

// Include defined functions
require_once("functions.php");

//make sure they are logged in
if ($_SESSION['authenticated'] != true) {
    header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}

// Print the html head with a title
print_html_header("Insert Question");

// Assume no error
$error = false;

//  Only process if $_POST is not empty 
if (!empty($_POST)) {
	
	/* Build field and value list
	 $v will be of the form 'value1', 'value2', etc.
	 $k will be of teh form  field1, field2, etc.
	 These variables ensure that the query will 
	 correctly match the fields and values */
	 
	$v = '';
	$k = '';
	foreach ($_POST as $key=>$value) {
	
		// If any value is blank, we have an error, so break out of the loop
		if ($value == "") {
			$error = true;
			break;
		}
		$v .= "'".$value."',";
		$k .= $key.",";
	}
	
	// Only run the query if there is no error
	if (!$error) {
		// We have to trim the right-most comma from the lists
		$v = rtrim($v,",");
		$k = rtrim($k,",");
	
		// Connect to datbase and execute query
		$mysqli = db_connect();				
		$sql = "INSERT INTO Questions8675309 ($k) VALUES ($v)";
		$mysqli->query($sql);

		/* Print all the questions as a Bootstrap formatted table
		  This is really for debugging and for administrators
		  This shows how you can easily add output by
		  calling reusable functions */
		
        echo '
        <div class="alert alert-success text-center">
            Your question has been added successfully!
        </div>';
        
		//print_question_table($mysqli);
        
        // Print a button to insert another question
		print_button("insert_question.php", "Insert Another Question");
		
		$mysqli->close();
	}
	
}	
if (empty($_POST) || $error) {
	print_insert_question_form_bs("insert_question.php", $error, $_POST, $c);
}

print_html_footer(); 
?>