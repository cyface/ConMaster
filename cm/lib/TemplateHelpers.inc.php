<?php

/**
 * TemplateHelpers
 *
 * Convienience functions for dealing with mass setting TemplatePower
 * substitution variables.
 *
 * These are mainly used by FormObject.php and form_merge.php
 *
 * CVS Info: $Id: TemplateHelpers.inc.php,v 1.10 2002/07/26 23:07:43 cyface Exp $
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
    // Put the values into the form
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
	    // Put the values into the form
	    foreach ($inHash as $key => $value) {
	        if (is_array($value)) {
	            foreach ($value as $subKey => $subValue) {
	                $inTemplate->assign($key . '[' . $subKey . ']', stripslashes($subValue));
					//echo '<PRE>Key: '; echo $key . '[' . $subKey . ']' . '=' . stripslashes($subValue); echo '<PRE>'; //Testing Only
	            }
	        } else {
	            $inTemplate->assign($key, stripslashes($value));
	        }
	    }
	}
    return true;
}

/**
 * rowFill creates new block rows and assigns each element of an associative array to the matching spot on the form
 * @param Array $inHash - a hashtable of key value pairs to assign to spots on the form
 * @param TemplatePower $inTemplate - a TemplatePower Object that has already been inited
 * @see TemplatePower
 **/
function rowFill ($inHash, &$inTemplate)  //& means that we can change inTemplate
{
	if ($inHash) { //Don't do anything if inHash is null
	    //echo '<PRE>'; print_r ($inHash); echo '<PRE>'; //Testing Only
	    // Put the values back into the form
	    foreach ($inHash as $key => $value) {
        	//echo '<PRE> Key:<br>'; print_r($key); echo '</PRE>';
        	//echo '<PRE> Value:<br>'; print_r($value); echo '</PRE>';
	        if (is_array($value)) {
				foreach ($value as $subKey => $subValue) { //subKey= reg_type, subValue is numeric array
					//echo '<PRE> subKey:<br>'; echo $subKey; echo '</PRE>';
					if ($inTemplate->getVarValue("_ROOT." . $key . '[' . $subKey. ']'. '_length') != 0) { //If we have already set the length, we have already populated this one, and should exit
						break;
					}
					if (is_array($subValue)) {
						foreach ($subValue as $subSubValue) {
							$inTemplate->assign("_ROOT." . $key . '[' . $subKey. ']'. '_length',sizeof($subValue));
							$inTemplate->newBlock($key . '[' . $subKey. ']'. '_row'); //key: form_constants value=array with reg_type & table as values
							//echo '<PRE> block:<br>'; echo $key . '[' . $subKey . ']' . '_row'; echo '</PRE>';
							foreach ($subSubValue as $subSubSubKey => $subSubSubValue) {
								//echo '<PRE> final:<br>'; echo $key . '[' . $subKey . ']' . '[' . $subSubSubKey . ']' . '=' . stripslashes($subSubSubValue); echo '</PRE>';
								$inTemplate->assign($key . '[' . $subKey . ']' . '[' . $subSubSubKey . ']', stripslashes($subSubSubValue));
							}
						}
					} else {
						$inTemplate->assign($key . '[' . $subKey . ']', stripslashes($subValue));
						//echo '<PRE> final 1:<br>'; echo $key . '[' . $subKey . ']' . '=' . stripslashes($subValue); echo '</PRE>';
					}
				}
	        } else {
	            $inTemplate->assign($key, stripslashes($value));
	        }
	    }
	}
    return true;
}

?>
