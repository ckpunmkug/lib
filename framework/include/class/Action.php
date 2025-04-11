<?php

class Action
{
	static function install()
	{//{{{//
		
		echo("\nInstalation started\n");
		
		echo("\nCreate config dir\n");
		$path = CONFIG_DIR;
		$return = Filesystem::create_dir($path);
		if(!$return) {
			trigger_error("Can't create config dir", E_USER_WARNING);
			return(false);
		}
		
	}//}}}//
}

