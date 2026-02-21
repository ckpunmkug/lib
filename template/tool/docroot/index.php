<?php

define("DEBUG", true);
define("VERBOSE", !true);
define("QUIET", false);

$return = realpath(__DIR__.'/..');
define('DIR', $return);
set_include_path(DIR.'/include');

require_once('block/protection.php');
require_once('block/initialization.php');

require_once('class/Check.php');
require_once('function/encode.php');
require_once('function/decode.php');

require_once('function/t2h.php');
require_once('class/HTML.php');
HTML::$head = '<link rel="icon" href="share/image/favicon.ico">'."\n";
HTML::$styles = [
	'share/style/main.css',
	'share/style/extension.css',
];
HTML::$script .= 'window.DEBUG = true;'."\n";
HTML::$scripts = [
	'share/script/main.js',
	'share/script/keyboard.js',
	'share/script/display.js',
	'share/script/transceiver.js',
	'share/script/tool.js',
];

require_once('function/main.php');
require_once('class/Main.php');
require_once('class/Page.php');
require_once('class/Action.php');
$return = main();
if($return !== true) {
	http_response_code(500);
	trigger_error("Main call failed", E_USER_ERROR);
	exit(255);
}
exit(0);

__halt_compiler();

