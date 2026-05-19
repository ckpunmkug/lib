<?php
var_dump($_GET);
define('VERBOSE', true);
if(defined('VERBOSE') && VERBOSE) 
	file_put_contents('php://stderr', "\nabcd\n");
//phpinfo();
