<?php

include_once('./lib/FormObject2.php');

$formHandler = new FormObject2($_GET,$_POST); //make a new FormObject handler object

if ($formHandler->processAction()) {
	//do anything custom here.
    $formHandler->display();
} else {
	echo "Failed.";
}
?>
