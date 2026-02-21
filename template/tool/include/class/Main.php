<?php

class Main
{
	static function handle_get_request()
	{//{{{
		
		$page = @strval($_GET["page"]);
		switch($page) {
			case(""):
			$return = Page::index();
			break;
			
			case("warning"):
			$return = Page::warning();
			break;
			
			case("error"):
			$return = Page::error();
			break;
		
			default:
			if(defined('DEBUG') && DEBUG) var_dump(['$page' => $page]);
			trigger_error("Passed page not supported", E_USER_WARNING);
			return(NULL);
		}
		
		if($return !== true) {
			if(defined('DEBUG') && DEBUG) var_dump(['$page' => $page]);
			trigger_error("Can't create page", E_USER_WARNING);
			return(false);
		}
		
		return(true);
	
	}//}}}
	
	static function handle_post_request()
	{//{{{
	
		$action = @strval($_POST["action"]);
		switch($action) {
			case('complete'):
			$return = Action::complete();
			break;
			
			case('warning'):
			$return = Action::warning();
			break;
			
			case('error'):
			$return = Action::error();
			break;
			
			default:
			if(defined('DEBUG') && DEBUG) var_dump(['$action' => $action]);
			trigger_error("Passed action not supported", E_USER_WARNING);
			return(NULL);
		}
		
		if($return === false) {
			if(defined('DEBUG') && DEBUG) var_dump(['$action' => $action]);
			trigger_error("Action failed", E_USER_WARNING);
			return(false);
		}
		$result = [
			"action" => $action,
			"data" => $return,
		];
		
		return($result);
		
	}//}}}
}

