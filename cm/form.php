<?php

require_once('conmaster.php');
require_once('FormObject.php');
require_once('ErrorCheck.php');

$formHandler = new FormObject($_GET,$_POST); //make a new FormObject handler object

errorCheck($formHandler); //If $formHandler is an error, display and exit

errorCheck($formHandler->processAction());

$formHandler->display();

?>
