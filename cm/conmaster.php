<?php

	require_once('./config/include_path.php');
	include_once('PEAR.php');
	
	session_start();
	
	$_SESSION['last_uri']=$REQUEST_URI;
	
	// initialize DataObject from the ini files in the config directory
	//$iniFileArray = &PEAR::getStaticProperty('DB_DataObject', 'options');
	//$config = parse_ini_file('config/conmaster.ini', true);
	//$iniFileArray = $config['DB_DataObject'];
	
	require_once('./auth.php');

?>