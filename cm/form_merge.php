<?php

include_once('conmaster.php');
require_once('class.TemplatePower.inc.php');
require_once('TemplateHelpers.inc.php');

if (!$_GET['template']) { //If they didn't pass a template name, exit
	echo "No template specified.";
    return false;
}

$template = new TemplatePower ('./templates/' . $_GET['template']);
$template->prepare();

valueFill($_GET,$template);

$template->printToScreen();

?>
