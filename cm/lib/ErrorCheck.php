<?php

include_once('PEAR.php');
include_once('ErrorCheck.php');

function errorCheck ($inObject) {
    if (PEAR::isError($inObject)) {
    	if ($inObject->getCode() != '') {
    		return $inObject->getMessage();
    	}
        trigger_error('Fatal Error: ' . $inObject->getMessage(),E_USER_ERROR);
        return;
    }
} //End function errorCheck

?>