<?php

$return = realpath(__DIR__.'/..');
if(!is_string($return)) {
	trigger_error("Unable to get real path of project root folder", E_USER_ERROR);
	exit(255);
}
define('DIR', $return);

set_include_path(DIR.'/include');
require('block/initialization.php');

require('class/HTML.php');
require('function/form.php');

require('project/Page.php');
require('project/Action.php');

require('class/Main.php');
Main::switch_request_method();

