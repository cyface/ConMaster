<?php

include_once('./lib/ItemBean.php');
include_once('./lib/class.TemplatePower.inc.php');
include_once('./lib/TemplateHelpers.inc.php');

session_start(); //Just in case

$tpl = new TemplatePower('./item_search.tpl'); //make a new TemplatePower object

$tpl->prepare();//let TemplatePower do its thing, parsing etc.

//If we got search criteria in from the form, do a search!
if ($_POST['search']) {
	valueFill($_POST['search'],$tpl); //Put the search values back in the form fields

	$item = new ItemBean;
	$results = $item->find_all($_POST['search']);
	
	foreach ($results as $row) {
		$tpl->newBlock("result_row"); //create a new text_row block
		valueFill($row,$tpl);
	}
}
$tpl->printToScreen(); //Redisplay the edit form, for futher edits or whatever.

?>
