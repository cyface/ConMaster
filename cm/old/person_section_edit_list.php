<?php

include_once('./lib/DBObject.php');
include_once('./lib/class.TemplatePower.inc.php');
include_once('./lib/TemplateHelpers.inc.php');

session_start(); //Just in case

$tpl = new TemplatePower('./person_section_edit_list.tpl'); //make a new TemplatePower object

$tpl->prepare();//let TemplatePower do its thing, parsing etc.

//If we got search criteria in from the form, do a search!
if ($_GET['person_id'])  {

	$person_section = new DBObject('person_section'); //Create a new Object to hold the values and execute the save.

	if ($_GET['person_section_id']& $_GET['action'] == 'delete') {
	    $person_section->delete($_GET['person_section_id']);
	}

	$section = new DBObject('section');
	$event = new DBObject('event');

	valueFill(array('person_id' => $_GET['person_id']),$tpl);

	$results = $person_section->find_all(array('person_id' => $_GET['person_id']),array('person_id' => 'equals'));

	foreach ($results as $row) {
		$tpl->newBlock("event_row"); //create a new row block
		valueFill($row,$tpl);
		$section->load_all($row['section_id']);
		$section_row = $section->get_data();
		$date_elements =  explode("-" ,$section_row['slot_date']);
		$tpl->assign('slot_date',date('D',mktime(0,0,0 ,$date_elements [1], $date_elements[ 2],$date_elements [0])));
		$tpl->assign('start_time',date('g:iA',strtotime($section_row['start_time'])));
		$tpl->assign('end_time',date('g:iA',strtotime($section_row['end_time'])));

		$event->load_all($section_row['event_id']);
		$event_row = $event->get_data();
		$tpl->assign('event_name',$event_row['event_name']);
		$tpl->assign('event_id',$event_row['id']);
	}
}

$tpl->printToScreen(); //Redisplay the form, for futher edits or whatever.
?>
