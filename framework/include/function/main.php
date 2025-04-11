<?php

function main(array $argv)
{
	$return = Main::get_home_dir();
	if(!is_string($return)) {
		trigger_error("Can't get 'home dir'", E_USER_WARNING);
		return(false);
	}
	define('HOME_DIR', $return);
	
	define('CONFIG_DIR', HOME_DIR.'/.config/'.VENDOR.'/'.PROJECT_NAME);
	define('SHARE_DIR', HOME_DIR.'/.share/'.VENDOR.'/'.PROJECT_NAME);
	define('CACHE_DIR', HOME_DIR.'/.cache/'.VENDOR.'/'.PROJECT_NAME);

	if(defined('ACTION') && ACTION == 'install') {
		$return = Action::install();
		if($return) {
			echo("Installation complete\n");
			return(true);
		}
		else {
			trigger_error("Installation failed", E_USER_WARNING);
			return(false);
		}
	}
	
	return(true);
}

