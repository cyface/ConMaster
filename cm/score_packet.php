<?php

include_once('PEAR.php');
include_once('./lib/ScorePacketFormObject.php');
include_once('./lib/ErrorCheck.php');

$formHandler = new ScorePacketFormObject($_GET,$_POST); //make a new FormObject handler object

errorCheck($formHandler); //If $formHandler is an error, display and exit

errorCheck($formHandler->processAction());

$formHandler->display();

?>
