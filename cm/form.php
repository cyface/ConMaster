<?php

require_once('conmaster.php');
include_once('PEAR.php');
include_once('FormObject.php');
include_once('ErrorCheck.php');

$formHandler = new FormObject($_GET,$_POST); //make a new FormObject handler object

errorCheck($formHandler); //If $formHandler is an error, display and exit

errorCheck($formHandler->processAction());

$formHandler->display();

?>
