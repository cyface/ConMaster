<?php

	require_once('./config/include_path.php');
	include_once('PEAR.php');
	
	$config = parse_ini_file('config/conmaster.ini', true);
	$iniFileArray = $config['ConMaster'];
	
	require_once('./auth.php');
?>