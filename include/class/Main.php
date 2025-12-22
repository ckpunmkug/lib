<?php

class Main
{
	static function start()
	{//{{{
		
		$request_method = @strval($_SERVER["REQUEST_METHOD"]);
		switch($request_method) {
			case('GET'):
				$return = self::handle_get_request();
				if($return !== true) {
					http_response_code(500);
					trigger_error("Handle get request failed", E_USER_ERROR);
					exit(255);
				}
				exit(0);
			case('POST'):
				$return = self::handle_post_request();
				if($return !== true) {
					http_response_code(500);
					trigger_error("Handle post request failed", E_USER_ERROR);
					exit(255);
				}
				exit(0);
			default:
				http_response_code(500);
				trigger_error("Unsupported http request method", E_USER_ERROR);
				exit(255);
		}
		
	}//}}}
	
	static function handle_get_request()
	{//{{{
		
		require('class/HTML.php');
		require('function/form_layout.php');
		$HTML = new HTML();
		
		return(true);
		
		label_404:
		http_response_code(404);
		HTML::$title = '404 Not Found';
		HTML::$body = 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>

HEREDOC;
////////////////////////////////////////////////////////////////////////////////
		return(true);
	
	}//}}}
	
	static function handle_post_request()
	{//{{{
	
		$csrf_token = @strval($_POST["csrf_token"]);
		if($csrf_token !== CSRF_TOKEN) goto label_403;
	
		return(true);
	
		label_403:
		http_response_code(403);
		$html = 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
		<title>403 Access forbidden!</title>
	</head>
	<body>
<h1>Access forbidden!</h1>
<p>You don't have permission to access the requested object.</p>

	</body>
</html>
HEREDOC;
////////////////////////////////////////////////////////////////////////////////
		echo($html);
		return(true);
		
	}//}}}
}

