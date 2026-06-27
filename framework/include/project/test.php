<?php

if(!defined('TEST')) die;

if(true) // Test verbose, debug, notice, warning, exception messages
{//{{{//
	
	if(defined('VERBOSE') && VERBOSE) {
		trigger_error("Test notice", E_USER_NOTICE);
	}

	if(defined('DEBUG') && DEBUG) var_dump(['value' => 123456]);
	trigger_error("Test warning", E_USER_WARNING);

	throw new Exception("Test exception");
	exit(255);	
	
}//}}}//

