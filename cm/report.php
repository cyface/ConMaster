<?php

include_once('./lib/ReportObject.php');

$reportHandler = new ReportObject($_GET,$_POST); //make a new ReportObject handler object

if (!$reportHandler->showReport()) {
	echo "Failed.";
}

?>
