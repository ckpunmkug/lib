<?php

function get_PATH($directory) 
{//{{{
	if(!is_string($directory))
		trigger_error('Passed variable "$directory" is not string', E_USER_ERROR);
		
	$result = [];
	
	$PATH = [$directory];
	for($index = 0; $index < count($PATH); $index++) {
		if(is_dir($PATH[$index]) !== true) {
			continue;
		}
		$path = $PATH[$index];
		
		$resource = opendir($path);
		if(is_resource($resource) !== true) {
			if (defined('DEBUG') && DEBUG) var_dump(['$path' => $path]);
			trigger_error("Can't open directory for read contents", E_USER_WARNING);
			continue;
		}
		
		while (true) {
			$name = readdir($resource);
			if(is_string($name) !== true) { 
				break;
			}
			if($name == "." || $name == "..") {
				continue;
			}
			
			array_push($PATH, "{$path}/{$name}");
		}
	}
	
	return($PATH);
}//}}}

