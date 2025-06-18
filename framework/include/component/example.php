<?php

class example
{//{{{//

	static $bool = NULL;
	static $int = NULL;
	static $float = NULL;
	static $string = NULL;
	static $array = NULL;
	
	static function main(array $config, string $action, string $data, string &$out)
	{//{{{//
		
		$return = self::set_parameters_from_configuration($config);
		if($return !== true) {
			if (defined('DEBUG') && DEBUG) var_dump(['config array' => $config]);
			trigger_error("Can't set class parameters from config array", E_USER_WARNING);
			return(false);
		}
		
                $ACTION = ['test'];
                if(in_array($action, $ACTION)) {
                        $return = self::$action($data, $out);
                        if(!$return) {
                                trigger_error("Action {$action} failed", E_USER_WARNING);
                                return(false);
                        }
                }
                else {
                        trigger_error("Unsupported action", E_USER_WARNING);
                        return(false);
                        
                }
		
		return(true);
		
	}//}}}//
	
	static function set_parameters_from_configuration(array $config)
	{//{{{//
		
		if(!eval(Check::$bool.='$config["bool"]')) return(false);
		self::$bool = $config["bool"];
		
		if(!eval(Check::$int.='$config["int"]')) return(false);
		self::$int = $config["int"];
		
		if(!eval(Check::$float.='$config["float"]')) return(false);
		self::$float = $config["float"];
		
		if(!eval(Check::$string.='$config["string"]')) return(false);
		self::$string = $config["string"];
		
		return(true);
		
	}//}}}//

	static function test(string $data, string &$out)
	{//{{{//
		
		self::$array = [
			&self::$bool,
			&self::$int,
			&self::$float,
			&self::$string,
		];
		var_dump(self::$array);
		return(true);
		
	}//}}}//

}//}}}//

