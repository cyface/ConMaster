<?php

include_once('conmaster.php');
include_once('ReportObject.php');

$reportHandler = new ReportObject($_GET,$_POST); //make a new ReportObject handler object

if (!$reportHandler->showReport()) {
	echo "Failed.";
}

?>
