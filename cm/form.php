<?php

include_once('./lib/FormObject.php');

$formHandler = new FormObject($_GET,$_POST); //make a new FormObject handler object

if ($formHandler->processAction()) {
	//do anything custom here.
    $formHandler->display();
} else {
	echo "Failed.";
}
?>
