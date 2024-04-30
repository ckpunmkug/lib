<?php

function import($filename) // Load JSON representation from file and decode it to value in appropriate PHP type.
{//{{{
	if(!is_string($filename)) // Path to file with JSON representation
		trigger_error('Passed variable "$filename" is not string', E_USER_ERROR);
	
	$result = false; // Return the value in appropriate PHP type (objects will be converted into associative arrays) or false if failure.
	
	$contents = file_get_contents($filename);
	if(is_string($contents) !== true) {
		if (defined('DEBUG') && DEBUG) var_dump(['$filename' => $filename]);
		trigger_error("Can't get JSON representation from file", E_USER_WARNING);
		return(false);
	}
	
	$variable = json_decode($contents, true);
	$error = json_last_error();
	if($variable === NULL && $error !== JSON_ERROR_NONE) {
		if (defined('DEBUG') && DEBUG) var_dump(['$contents' => $contents]);
		$error_msg = json_last_error_msg();
		trigger_error("JSON {$error_msg}", E_USER_WARNING);
		trigger_error("Can't JSON representation decode", E_USER_WARNING);
		return(false);
	}
	
	return($variable);
}//}}}

