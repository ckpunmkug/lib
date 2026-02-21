<?php

function main()
{//{{{//
	
	$request_method = @strval($_SERVER["REQUEST_METHOD"]);
	switch($request_method) {
		case('GET'):
			$return = Main::handle_get_request();
			if($return === NULL) {
				http_response_code(404);
				return(true);
			}
			if($return !== true) {
				trigger_error("Handle get request failed", E_USER_WARNING);
				return(false);
			}
			
			$ob = ob_get_clean();
			$ob = t2h($ob);
			if(strlen($ob) > 0) {
				HTML::$body = '<div id="output_buffer">'.$ob."</div>\n".HTML::$body;
			}
			
			HTML::echo();
			return(true);
			
		case('POST'):
			$return = Main::handle_post_request();
			if($return === NULL) {
				http_response_code(404);
				return(true);
			}
			if(!is_array($return)) {
				trigger_error("Handle post request failed", E_USER_WARNING);
				return(false);
			}
			$data = $return;
			
			$ob = ob_get_clean();
			if(strlen($ob) > 0) {
				$data["output"] = $ob;
			}
			
			$json = encode($data);
			if(!is_string($json)) {
				trigger_error("Can't encode data array to json", E_USER_WARNING);
				return(false);
			}
			
			http_response_code(201);
			header("Content-Type: application/json");
			echo($json);
			
			return(true);
			
		default:
			trigger_error("Unsupported http request method", E_USER_WARNING);
			return(false);
	}	
	
	return(true);
	
}//}}}//

