<?php

	$path_components = array();

	array_push ($path_components, './lib');
	array_push ($path_components, './lib/pear');

	//Combine the path components with the appropriate OS-specific separator
	if ( stristr(ini_get("include_path"), ';') ) {
		$path = join ($path_components,';') . ';';
	} else {
		$path = join ($path_components,':') . ':';
	}

	ini_set('include_path', $path . ini_get('include_path') );

	//echo ini_get("include_path");  //Debugging only
?>
