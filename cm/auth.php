<?php

require_once "Auth/Auth.php";

$dsn = $iniFileArray['dsn'];
$authenticator = new Auth("DB", $dsn);
$authenticator->setShowLogin(false); //Don't use the Auth login screen

$authenticator->start();

if (!$authenticator->getAuth()) { //If Authentication failed
	if ($authenticator->getStatus()==AUTH_WRONG_LOGIN) {
		header("Location: index.php?failed=1");
		die;
    } else {
    	header("Location: index.php");
    	die;
    }
}

if (isset($_REQUEST['username'])) { //If we came directly from the login form
	header("Location: main.html");
	die;
}

?>
