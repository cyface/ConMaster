<?php

/**
 * TemplateHelpers
 *
 * Convienience functions for dealing with mass setting TemplatePower
 * substitution variables.
 *
 * These are mainly used by FormObject.php and form_merge.php
 *
 * CVS Info: $Id: TemplateHelpers.inc.php,v 1.8 2002/07/18 21:33:09 cyface Exp $
 *
 * This class is copyright (c) 2002 by Tim White
 * @author Tim White <tim@cyface.com>
 * @since PHP 4.0
 * @copyright This class is copyright (c) 2002 by Tim White
 * @see TemplatePower
 * @see DBObject
 **/

require_once('./lib/class.TemplatePower.inc.php');

/**
 * errorFill
 * @param DBObject $inObject - a DBobject that has validation_results
 * @param TemplatePower $inTemplate - a TemplatePower Object that has already been inited
 * @see TemplatePower
 * @see DBObject
 **/
function errorFill ($inObject, &$inTemplate)
{
    // Fill in the error message placeholders with the save errors
    foreach ($inObject->validation_results as $key => $value) {
        $inTemplate->assign($key . '_error' , stripslashes($value));
		if (is_array($value)) {
			foreach ($value as $subKey => $subValue) {
				$inTemplate->assign($key . '[' . $subKey . ']', stripslashes($subValue));
			}
		} else {
			$inTemplate->assign($key, stripslashes($value));
		}
    }

    return true;
}

/**
 * objectValueFill assigns each property of an object to the matching spot on the form
 * @param Array $inDBObject - a DBObject object
 * @param TemplatePower $inTemplate - a TemplatePower Object that has already been inited
 * @see TemplatePower
 **/
function objectValueFill ($inDBObject, &$inTemplate)
{
    // Put the values back into the form
    foreach (get_object_vars($inDBObject) as $key => $value) {
        // echo '<PRE> Value:'; print_r($value); echo '</PRE>';
        if (is_object($value)) { // The related stuff
            foreach ($value as $subKey => $subValue) {
                $inTemplate->assign($key . '[' . $subKey . ']', stripslashes($subValue));
            }
        } else {
            $inTemplate->assign($key, stripslashes($value));
        }
    }
    return true;
}

/**
 * valueFill assigns each element of an associative array to the matching spot on the form
 * @param Array $inHash - a hashtable of key value pairs to assign to spots on the form
 * @param TemplatePower $inTemplate - a TemplatePower Object that has already been inited
 * @see TemplatePower
 **/
function valueFill ($inHash, &$inTemplate)  //& means that we can change inTemplate
{
	if ($inHash) { //Don't do anything if inHash is null
	    //echo '<PRE>'; print_r ($inHash); echo '<PRE>'; //Testing Only
	    // Put the values back into the form
	    foreach ($inHash as $key => $value) {
	        if (is_array($value)) {
	            foreach ($value as $subKey => $subValue) {
	                $inTemplate->assign($key . '[' . $subKey . ']', stripslashes($subValue));
	            }
	        } else {
	            $inTemplate->assign($key, stripslashes($value));
	        }
	    }
	}
    return true;
}

?>
