<?php

class Main
{
	static function get_home_dir()
	{//{{{//
		
		$return = getenv('HOME', true);
		if(!is_string($return)) {
			trigger_error("Can't get 'HOME' environment", E_USER_WARNING);
			return(false);
		}
		$path = $return;
		
		$return = realpath($path);
		if(!is_string($return)) {
			if (defined('DEBUG') && DEBUG) var_dump(['$path' => $path]);
			trigger_error("Can't get real path for 'home dir'", E_USER_WARNING);
			return(false);
		}
		$path = $return;
		
		$return = is_dir($path);
		if(!$return) {
			if (defined('DEBUG') && DEBUG) var_dump(['$path' => $path]);
			trigger_error("'home dir' is not dir", E_USER_WARNING);
			return(false);
		}
		
		return($path);
		
	}//}}}//
}

