<?php

require_once('./lib/class.TemplatePower.inc.php');
require_once('./lib/TemplateHelpers.inc.php');

if (!$_GET['template']) { //If they didn't pass a template name, exit
    return false;
}

$template = new TemplatePower ('./templates/' . $_GET['template']);
$template->prepare();

valueFill($_GET,$template);

$template->printToScreen();

?>