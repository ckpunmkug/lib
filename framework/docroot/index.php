<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('html_errors', '0');

$return = realpath(__DIR__.'/..');
if(!is_string($return)) {
	trigger_error("Unable to get real path of project root folder", E_USER_ERROR);
	exit(255);
}
define('DIR', $return);

set_include_path(DIR.'/include');
require('block/initialization.php');

require('class/HTML.php');
require('function/layout_form.php');
require('function/t2h.php');

require('project/Page.php');
require('project/Layout.php');

require('project/Action.php');
require('project/Method.php');

require('class/Main.php');
new Main;

