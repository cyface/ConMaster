<?php

require_once('conmaster.php');

header("Content-type: application/force-download");

$myfile = $_GET['filename'];

if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
  header("Content-Disposition: filename=$myfile" . "%20"); // For IE
} else {
  header("Content-Disposition: attachment; filename=$myfile"); // For Other browsers
}

require_once('ReportObject.php'); //Object to perform the export

$exportObject = new ReportObject($_GET);

$resultArray = $exportObject->getRawResults();

//Header Row
$headerRow .= 'first_name' . ',';
$headerRow .= 'last_name' . ',';
$headerRow .= 'street' . ',';
$headerRow .= 'city' . ',';
$headerRow .= 'state' . ',';
$headerRow .= 'zip' . ',';
$headerRow .= 'country' . ',';
$headerRow .= 'badge_number' . ',';
$headerRow .= 'reg_type' . ',';
$headerRow .= 'total_fee' . ',';
$headerRow .= 'amount_paid' . ',';
$headerRow .= 'amount_owed' . ',';
$headerRow .= 'event_block' . "\r\n";
echo $headerRow;

//Main data
$last_person_id = false;
$output = '';
$eventBlock = '';
foreach ($resultArray as $rowId=>$row) {
	if (($last_person_id == $row['person_id']) OR ($last_person_id == false)) { //Still on same person, aggregate events
		$eventBlock .= $row['complete_event_number'] . ":\t";
		$eventBlock .= $row['event_name'] . "\t";
		$eventBlock .= $row['date'] . " ";
		$eventBlock .= $row['start_time'] . "-";
		$eventBlock .= $row['end_time'] . "\t";
		$eventBlock .= '$' . $row['price'];
		$eventBlock .= "\r";
	} else {
		$output .= "\"" . $row['first_name'] . "\",";
		$output .= "\"" . $row['last_name'] . "\",";
		$output .= "\"" . $row['street'] . "\",";
		$output .= "\"" . $row['city'] . "\",";
		$output .= "\"" . $row['state'] . "\",";
		$output .= "\"" . $row['zip'] . "\",";
		$output .= "\"" . $row['country'] . "\",";
		$output .= "\"" . $row['badge_number'] . "\",";
		$output .= "\"" . $row['reg_type'] . "\",";
		$output .= "\"" . $row['total_fee'] . "\",";
		$output .= "\"" . $row['amount_paid'] . "\",";
		$output .= "\"" . $row['amount_owed'] . "\",";
		$output .= "\"" . $eventBlock . "\"\r\n";
		echo $output;
		$output = '';
		$eventBlock = '';
	}
	$last_person_id = $row['person_id'];
}
//Output final person
$output .= "\"" . $row['first_name'] . "\",";
$output .= "\"" . $row['last_name'] . "\",";
$output .= "\"" . $row['street'] . "\",";
$output .= "\"" . $row['city'] . "\",";
$output .= "\"" . $row['state'] . "\",";
$output .= "\"" . $row['zip'] . "\",";
$output .= "\"" . $row['country'] . "\",";
$output .= "\"" . $row['badge_number'] . "\",";
$output .= "\"" . $row['reg_type'] . "\",";
$output .= "\"" . $row['total_fee'] . "\",";
$output .= "\"" . $row['amount_paid'] . "\",";
$output .= "\"" . $row['amount_owed'] . "\",";
$output .= "\"" . $eventBlock . "\"\r\n";
echo $output;

?>