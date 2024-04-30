<?php

function export($filename, $variable) // Save a variable in JSON representation to a file.
{//{{{
	if(!is_string($filename)) // Path to file for a variable in JSON representation.
		trigger_error('Passed variable "$filename" is not string', E_USER_ERROR);
	
	// $variable - Variable that is converted to json (If it can)
		
	$result = false; // Return true if complete and false if failure.
	
	$json = json_encode($variable, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	if(is_string($json) !== true) {
		if (defined('DEBUG') && DEBUG) var_dump(['$variable' => $variable]);
		$error_msg = json_last_error_msg();
		trigger_error("{$error_msg}", E_USER_WARNING);
		trigger_error("Can't returns the JSON representation of a value", E_USER_WARNING);
		return(false);
	}
	
	$return = file_put_contents($filename, $json);
	if(is_int($return) !== true) {
		if (defined('DEBUG') && DEBUG) var_dump(['$filename' => $filename]);
		trigger_error("Can't write a JSON representation to a file", E_USER_WARNING);
		return(false);
	}
	
	return(true);
}//}}}

