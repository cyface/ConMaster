<?php

include_once('./lib/DBObject.php');
include_once('./lib/class.TemplatePower.inc.php');
include_once('./lib/TemplateHelpers.inc.php');

session_start(); //Just in case

$tpl = new TemplatePower('./person_section_edit.tpl'); //make a new TemplatePower object

$tpl->prepare();//let TemplatePower do its thing, parsing etc.

$person_section = new DBObject('person_section'); //Create a new Object to hold the values and execute the save.

if (empty($_GET['id']) & !empty($_POST['id'])) { //Trying to Save
	if ($person_section->update_all($_POST)) { //Try to save the values to the DB using the object
		$tpl->assign('action_message', '<font color="#66CC00">Saved</font>');
		valueFill($person_section->get_data(),$tpl);
	} else { //Something went wrong on save
		$tpl->assign('action_message', '<font color="#FF0000">Save Failed, Please Correct Errors</font>');
		valueFill($_POST,$tpl); //Put the values back into the form
		errorFill($person_section,$tpl); //Fill in the error message placeholders with the save errors
	}
} else if (!empty($_GET['id'])) { //Display the edit form for the supplied
	if ($_GET['action'] == 'delete') {
	    $person_section->delete($_GET['id']);
	} else {
		$person_section->load_all($_GET['id']);
		valueFill($person_section->get_data(),$tpl);
	}
} else {
	$tpl->assign('action_message', '<font color="#FF0000">No ID Specified.</font>');
}

$tpl->printToScreen(); //Redisplay the edit form, for futher edits or whatever.

unset($person_section); //Destroy the object
?>
