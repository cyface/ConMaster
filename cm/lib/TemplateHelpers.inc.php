<?php

include_once('./lib/class.TemplatePower.inc.php');

/**
* errorFill
*
* @param DBObject $inObject - a DBobject that has validation_results
* @param TemplatePower $inTemplate - a TemplatePower Object that has already been inited
* @see TemplatePower
* @see DBObject
*/
function errorFill ($inObject, $inTemplate) {
	//Fill in the error message placeholders with the save errors
	foreach ($inObject->validation_results as $key => $value) {
		$inTemplate->assign($key . '_error' , stripslashes($value));
	}

	return true;
}

/**
* objectValueFill
*
* @param Array $inDBObject - a DBObject object
* @param TemplatePower $inTemplate - a TemplatePower Object that has already been inited
* @see TemplatePower
*/
function objectValueFill ($inDBObject, $inTemplate) {
	//Put the values back into the form
	foreach ($inDBObject->get_data() as $key => $value) {
		$inTemplate->assign($key, stripslashes($value));
	}

	return true;
}

/**
* valueFill
*
* @param Array $inHash - a hashtable of key value pairs to assign to spots on the form
* @param TemplatePower $inTemplate - a TemplatePower Object that has already been inited
* @see TemplatePower
*/
function valueFill ($inHash, $inTemplate) {
	//Put the values back into the form
	foreach ($inHash as $key => $value) {
		$inTemplate->assign($key, stripslashes($value));
	}

	return true;
}

?>