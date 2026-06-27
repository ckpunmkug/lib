<?php

class Main
{

	static function switch_request_method()
	{//{{{
		
		if(PHP_SAPI == 'cli') {
			$return = self::console_handle();
			if($return !== true) {
				throw new Exception("Console handle failed");
				exit(255);
			}
			exit(0);
		}
		
		$request_method = @strval($_SERVER["REQUEST_METHOD"]);
		switch($request_method) {
			case('GET'):
				$return = self::handle_get_request();
				if($return !== true) {
					http_response_code(500);
					throw new Exception("Handle get request failed");
					exit(255);
				}
				exit(0);
			case('POST'):
				$return = self::handle_post_request();
				if($return !== true) {
					http_response_code(500);
					throw new Exception("Handle post request failed");
					exit(255);
				}
				exit(0);
			default:
				http_response_code(500);
				throw new Exception("Unsupported http request method");
				exit(255);
		}
		
	}//}}}
	
	static function console_handle()
	{//{{{//
		
		if(!eval(Check::$array.='$GLOBALS["argv"]')) return(false);
		$argv = $GLOBALS["argv"];
		
		array_shift($argv);
		if(count($argv) == 0) {
			trigger_error("Flag(s) or action not set", E_USER_WARNING);
			return(false);
		}
		
		self::command_startup_flags($argv);
		if(defined('TEST')) {
			require('project/test.php');
			return(true);
		}
		
		if(count($argv) == 0) {
			trigger_error("Action not set", E_USER_WARNING);
			return(false);
		}
		$METHOD = get_class_methods('Console');
		$method = array_shift($argv);
		if(!in_array($method, $METHOD)) {
			if(defined('DEBUG') && DEBUG) var_dump(['action' => $method]);
			trigger_error("Unsupported given action", E_USER_WARNING);
			return(false);
		}
		
		$parameters = [];
		$ReflectionMethod = new ReflectionMethod('Console', $method);
		$PARAMETER = $ReflectionMethod->getParameters();
		foreach($PARAMETER as $parameter) {

			$name = $parameter->getName();
			$type = $parameter->getType();
			$type = $type->getName();
			$optional = $parameter->isOptional();
			
			if(count($argv) == 0 && $optional != true) {
				trigger_error("Argument '{$name}' not set", E_USER_WARNING);
				return(false);
			}
			if(count($argv) == 0 && $optional == true) break;
			
			$v = array_shift($argv);
			
			switch($type) {
				case('string'):
				$v = strval($v);
				break;
				
				case('int'):
				$v = intval($v);
				break;
				
				case('float'):
				$v = floatval($v);
				break;
				
				default:
				if(defined('DEBUG') && DEBUG) var_dump(['method' => $method]);
				trigger_error("Unsupported parameter type in 'Console' method", E_USER_WARNING);
				return(false);
			}
			array_push($parameters, $v);
			
		}// foreach($PARAMETER as $parameter)

		$return = call_user_func_array("Console::{$method}", $parameters);
		if($return !== true) {
			trigger_error("Console method '{$method}' failed", E_USER_WARNING);
			return(false);
		}
		
		return(true);
		
	}//}}}//
	
	static function command_startup_flags(array &$argv)
	{//{{{//
		
		if($argv[0] == '-h' || $argv[0] == '--help') {
			
			$actions = '';
			$METHOD = get_class_methods('Console');
			foreach($METHOD as $method) {
			
				if(strlen($actions) != 0) {
					$actions .= "\n";
				}
				$actions .= sprintf("  %s  ", $method);
				$parameters = '';
				
				$ReflectionMethod = new ReflectionMethod('Console', $method);
				$PARAMETER = $ReflectionMethod->getParameters();
				foreach($PARAMETER as $parameter) {

					$name = $parameter->getName();
					$type = $parameter->getType();
					$type = $type->getName();
					$optional = $parameter->isOptional();
					
					if(strlen($parameters) != 0) {
						$parameters .= ' ';
					}
					
					if($optional) {
						$parameters .= "[{$name}]";
					}
					else {
						$parameters .= "{$name}";
					}
					
				}// foreach($METHOD as $method)
				
				$actions .= "{$parameters}";
			
			}// foreach($METHOD as $method)
			
			$help = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
\nSupported actions:
{$actions}

Flags:
  -d  debug
  -v  verbose
  -t  test

Examples:
  ./start -dvt
  ./start -dv action1 arg1 arg2
  ./start action0
\n
HEREDOC;
///////////////////////////////////////////////////////////////}}}//
			
			echo($help);
			
			exit(0);
		}
		
		$pattern = '/^\-([dvt]+)$/';
		$return = preg_match($pattern, $argv[0]);
		if($return == 1) {
			$string = array_shift($argv);
			
			$return = strpos($string, 'd');
			if(is_int($return)) {
				define('DEBUG', true);
			}
			
			$return = strpos($string, 'v');
			if(is_int($return)) {
				define('VERBOSE', true);
			}
			
			$return = strpos($string, 't');
			if(is_int($return)) {
				define('TEST', true);
			}
		}
		
		return(true);
		
	}//}}}//
	
	static function handle_get_request()
	{//{{{
		
		$PAGE = get_class_methods('Page');
		
		$page = 'index';
		if(isset($_GET["page"]) && is_string($_GET["page"])) {
			$page = $_GET["page"];
		}
		
		if(!in_array($page, $PAGE)) {
			if(defined('DEBUG') && DEBUG) var_dump(['$page' => $page]);
			self::http_response_code_404();
			return(true);
		}
		 
		$call = "Page::{$page}";
		$return = $call();
		if($return !== true) {
			if(defined('DEBUG') && DEBUG) var_dump(['$page' => $page]);
			trigger_error("Can't generate page", E_USER_WARNING);
			return(false);
		}
		
		return(true);
	
	}//}}}
	
	static function handle_post_request()
	{//{{{
	
		$csrf_token = @strval($_POST["csrf_token"]);
		if($csrf_token !== CSRF_TOKEN) {
			self::http_response_code_403();
			return(true);
		}
		
		if(!eval(Check::$string.='$_POST["action"]')) return(false);
		$action = $_POST["action"];
		
		$ACTION = get_class_methods('Action');
		
		if(!in_array($action, $ACTION)) {
			if(defined('DEBUG') && DEBUG) var_dump(['$action' => $action]);
			self::http_response_code_404();
			return(true);
		}
		 
		$call = "Action::{$action}";
		$return = $call();
		if($return !== true) {
			if(defined('DEBUG') && DEBUG) var_dump(['$action' => $action]);
			trigger_error("Action failed", E_USER_WARNING);
			return(false);
		}
		
		return(true);
		
	}//}}}

	static function http_response_code_403()
	{//{{{//
		
		http_response_code(403);
		HTML::$title = '403 Access forbidden!';
		HTML::$style = 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
body {
	background: white;
	color: black;
}
HEREDOC;
////////////////////////////////////////////////////////////////////////////////
		HTML::$body = 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
<h1>Access forbidden!</h1>
<p>You don't have permission to access the requested object.</p>

HEREDOC;
////////////////////////////////////////////////////////////////////////////////
		HTML::echo();
		return(true);
		
	}//}}}//
	
	static function http_response_code_404()
	{//{{{//
		
		http_response_code(404);
		HTML::$title = '404 Not Found';
		HTML::$style = 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
body {
	background: white;
	color: black;
}
HEREDOC;
////////////////////////////////////////////////////////////////////////////////
		HTML::$body = 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>

HEREDOC;
////////////////////////////////////////////////////////////////////////////////
		HTML::echo();
		return(true);
		
	}//}}}//
}

