<?php

include_once('./lib/PersonObject.php');
include_once('./lib/class.TemplatePower.inc.php');
include_once('./lib/TemplateHelpers.inc.php');

session_start(); //Just in case

$tpl = new TemplatePower('./person_edit.tpl'); //make a new TemplatePower object

$tpl->prepare();//let TemplatePower do its thing, parsing etc.

$person = new DBObject('person'); //Create a new Object to hold the values and execute the save.

if (empty($_GET['id']) & !empty($_POST['id'])) { //Trying to Save
	if ($person->update_all($_POST)) { //Try to save the values to the DB using the object
		$tpl->assign('action_message', '<font color="#66CC00">Saved</font>');
		valueFill($person->get_data(),$tpl);
	} else { //Something went wrong on save
		$tpl->assign('action_message', '<font color="#FF0000">Save Failed, Please Correct Errors</font>');
		valueFill($_POST,$tpl); //Put the values back into the form
		errorFill($person,$tpl); //Fill in the error message placeholders with the save errors
	}
} else if (!empty($_GET['id'])) { //Display the edit form for the supplied
	$person->load_all($_GET['id']);
	valueFill($person->get_data(),$tpl);
} else {
	$tpl->assign('action_message', '<font color="#FF0000">No ID Specified.</font>');
}

$tpl->printToScreen(); //Redisplay the edit form, for futher edits or whatever.

unset($person); //Destroy the object
?>
