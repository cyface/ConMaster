<?php

include_once('./lib/ScorePacketFormObject.php');

$formHandler = new SCorePacketFormObject($_GET,$_POST); //make a new ScorePacketFormObject handler object

if ($formHandler->processAction()) {
	//do anything custom here.
    $formHandler->display();
} else {
	echo "Failed.";
}
?>
