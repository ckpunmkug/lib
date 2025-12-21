<?php

class Args 
{//{{{

	/* Usage {{{
	
		Args::$description = "Program description";
		Args::add([
			"-a", "--A", NULL, "not required parameter",
			function () {
				define("A", true);
			}, false
		]);
		Args::add([
			"-b", "--B", NULL, "required parameter",
			function () {
				define("B", true);
			}, true
		]);
		Args::add([
			"-c", "--C", "STRING", "not required parameter with value",
			function ($string) {
				define("C", $string);
			}, false
		]);
		Args::add([
			"-d", "--D", "STRING", "required parameter with value",
			function ($string) {
				define("D", $string);
			}, true
		]);
		Args::add([
			"-k", NULL, NULL, "only short key",
			function () {
				define("K", true);
			}, false
		]);
		Args::add([
			NULL, "--key", NULL, "only long key",
			function () {
				define("K", true);
			}, false
		]);
		Args::apply($argv);
		
	}}} */

	static $ARGV = "";
	static $description = "";
	static $config = [];
	
	static $stdout = NULL;
	static $stderr = NULL;
	static $null = NULL;
	
	static function help()
	{//{{{
	
		$text = "";
		
		if (!empty(self::$description))
			$text .= "\nDescription: ".self::$description."\n\n";
			
		$text .= "Parameters: \n";
		foreach (self::$config as $config) {
			$text .= "\n";
			
			for($index = 0; $index <= 2; $index += 1)
			{
				if( 
					is_string($config[$index])
					&& strlen($config[$index]) > 0
				) {
					$text .= "  {$config[$index]}";
				}
			}
			
			$text .= "\n\t{$config[3]}\n";
		}
		echo $text."\n";
		
		return(NULL);
		
	}//}}}
	
	static function apply(array $ARGV)
	{//{{{
	
		self::$ARGV = $ARGV;
	
		array_unshift(self::$config, [
			'-h', '--help', NULL, "Show help text and exit",
			function() {
				self::help();
				exit(0);
			}, false
		]);
		array_push(self::$config, [
			'-d', '--debug', NULL, "Run in debug mode", 
			function() {
				if(!defined('DEBUG')) define('DEBUG', true);
			}, false
		]);
		array_push(self::$config, [
			'-v', '--verbose', NULL, "Allow verbose messages to stderr", 
			function() {
				if(!defined('VERBOSE')) define('VERBOSE', true);
			}, false
		]);
		array_push(self::$config, [
			'-q', '--quiet', NULL, "Prevent output to stdout and stderr", 
			function() {
				define('QUIET', true);
				fclose(STDOUT);
				fclose(STDERR);				
			}, false
		]);
		
		foreach(self::$config as $parameter) {
			$found = false;
			foreach(self::$ARGV as $index => $argv) {
				
				$a = is_string($parameter[0]) && strlen($parameter[0]) > 0 && $parameter[0] == $argv;
				$b = is_string($parameter[1]) && strlen($parameter[1]) > 0 && $parameter[1] == $argv;
				if($a || $b) {		
				
					$value = NULL;
					if(is_string($parameter[2])) {
						if(!isset($ARGV[$index+1])) {
							var_dump([
								"short key" => $parameter[0],
								"long key" => $parameter[1],
							]);
							trigger_error("Value for passed key is not set", E_USER_ERROR);
							exit(255);
						}
						$value = $ARGV[$index+1];
					}
					
					if(is_string($value)) {
						$parameter[4]($value);
					} else {
						$parameter[4]();
					}
					$found = true;
					
				} // if($a || $b)
				
				if($parameter[5] && !$found) {
					var_dump([
						"short key" => $parameter[0],
						"long key" => $parameter[1],
					]);
					trigger_error("Required parameter not found", E_USER_ERROR);
					exit(255);
				}
				
			} // foreach(self::$ARGV as $index => $argv)
		} // foreach(self::$config as $parameter)
		
		return(NULL);
		
	}//}}}
	
	static function add(array $parameter)
	{//{{{
		
		if(!(
			key_exists(0, $parameter)
			&& (
				is_string($parameter[0])
				|| is_null($parameter[0])
			)
		)) {
			@var_dump(['$parameter[0]' => $parameter[0]]);
			trigger_error('Incorrect "short key (0)" parameter array for add to Args::$config', E_USER_ERROR);
			exit(255);
		}
		
		if(!(
			key_exists(1, $parameter)
			&& (
				is_string($parameter[1])
				|| is_null($parameter[1])
			)
		)) {
			@var_dump(['$parameter[1]' => $parameter[1]]);
			trigger_error('Incorrect "long key (1)" parameter array for add to Args::$config', E_USER_ERROR);
			exit(255);
		}
		
		if(!(
			key_exists(2, $parameter)
			&& (
				is_string($parameter[2])
				|| is_null($parameter[2])
			)
		)) {
			@var_dump(['$parameter[2]' => $parameter[2]]);
			trigger_error('Incorrect "key value (2)" parameter array for add to Args::$config', E_USER_ERROR);
			exit(255);
		}
		
		if(!(
			key_exists(3, $parameter)
			&& is_string($parameter[3])
		)) {
			@var_dump(['$parameter[3]' => $parameter[3]]);
			trigger_error('Incorrect "description (3)" parameter array for add to Args::$config', E_USER_ERROR);
			exit(255);
		}
		
		if(!(
			key_exists(4, $parameter)
			&& is_callable($parameter[4])
		)) {
			@var_dump(['$parameter[4]' => $parameter[4]]);
			trigger_error('Incorrect "function (4)" parameter array for add to Args::$config', E_USER_ERROR);
			exit(255);
		}
		
		if(!(
			key_exists(5, $parameter)
			&& is_bool($parameter[5])
		)) {
			@var_dump(['$parameter[5]' => $parameter[5]]);
			trigger_error('Incorrect "required flag (5)" in parameter array for add to Args::$config', E_USER_ERROR);
			exit(255);
		}
		
		array_push(self::$config, $parameter);
		
		return(NULL);
	
	}//}}}

}//}}}

