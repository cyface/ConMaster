<?php

header("Content-type: application/force-download");

if (isset($_POST['filename'])) {
	$myfile = $_POST['filename'];
} else {
	$myfile = $_GET['filename'];
}

if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
  header("Content-Disposition: filename=$myfile" . "%20"); // For IE
} else {
  header("Content-Disposition: attachment; filename=$myfile"); // For Other browsers
}

require_once('ReportObject.php'); //Object to perform the export

$reportObject = new ReportObject($_GET,$_POST);

$resultArray = $reportObject->getDelimitedResults();

foreach ($resultArray as $row) {
	echo $row;
}

?>