<?php

header("Content-type: application/force-download");

$myfile = $_GET['filename'];

if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
  header("Content-Disposition: filename=$myfile" . "%20"); // For IE
} else {
  header("Content-Disposition: attachment; filename=$myfile"); // For Other browsers
}

require_once('ExportObject.php'); //Object to perform the export

$exportObject = new ExportObject($_GET);

$resultArray = $exportObject->getFormattedResults();

foreach ($resultArray as $row) {
	echo $row;
}

?>