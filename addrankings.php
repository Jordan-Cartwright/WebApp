<?php
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON);
$display = $input->winner . "&gt;" . $input->loser;
$data = $input->winner . ">" . $input->loser . ",";

echo "<p>The following ordering was recorded:</p>";
echo "<p>$display</p>";

$filename = "rankings.txt";
$myfile = fopen($filename, "a");
if (!$myfile) {
   die("Unable to open $filename.");
}
fwrite($myfile, $data);
fclose($myfile);
?>
