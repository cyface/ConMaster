<?php

include_once('./lib/ItemBean.php');
include_once('./lib/class.TemplatePower.inc.php');
include_once('./lib/TemplateHelpers.inc.php');

session_start(); //Just in case

$tpl = new TemplatePower('./item_edit.tpl'); //make a new TemplatePower object

$tpl->prepare();//let TemplatePower do its thing, parsing etc.

$item = new ItemBean; //Create a new ItemBean to hold the values and execute the save.

if (empty($_GET['id']) & !empty($_POST['id'])) { //Trying to Save
	if ($item->update_all($_POST)) { //Try to save the values to the DB using the ItemBean
		$tpl->assign('action_message', '<font color="#66CC00">Item Saved</font>');
		valueFill($item->get_data(),$tpl);
	} else { //Something went wrong on save
		$tpl->assign('action_message', '<font color="#FF0000">Save Failed, Please Correct Errors</font>');

		//Put the values back into the form
		valueFill($_POST,$tpl);
		//Fill in the error message placeholders with the save errors
		errorFill($item,$tpl);
	}
} else if (!empty($_GET['id'])) { //Display the edit form for the supplied
	$item->load_all($_GET['id']);
	valueFill($item->get_data(),$tpl);
} else {
	$tpl->assign('action_message', '<font color="#FF0000">No ID Specified.</font>');
}

$tpl->printToScreen(); //Redisplay the edit form, for futher edits or whatever.

unset($item); //Destroy the ItemBean
?>
