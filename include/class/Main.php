<?php

class Main
{
	var $url_path = '';
	var $csrf_token = '';

	function __construct()
	{//{{{
		$return = get_url_path();
		if(!is_string($return)) {
			trigger_error("Can't get url path", E_USER_ERROR);
		}
		$this->url_path = $return;
	
		if(@is_string(CSRF_TOKEN) !== true) {
			trigger_error("Incorrect constant 'CSRF_TOKEN'", E_USER_ERROR);
		}
		$this->csrf_token = CSRF_TOKEN;
	
		$request_method = @strval($_SERVER["REQUEST_METHOD"]);
		switch($request_method) {
			case('GET'):
				$return = $this->handle_get_request();
				if($return !== true) {
					trigger_error("Handle get request failed", E_USER_ERROR);
				}
				exit(0);
			case('POST'):
				$return = $this->handle_post_request();
				if($return !== true) {
					trigger_error("Handle post request failed", E_USER_ERROR);
				}
				exit(0);
			default:
				trigger_error("Unsupported http request method", E_USER_ERROR);
		}
	}//}}}
	
	function handle_get_request()
	{//{{{
		$page = @strval($_GET["page"]);
		switch($page) {
			case(''):
				$return = $this->main();
				if($return !== true) {
					trigger_error("Can't create 'main' page", E_USER_WARNING);
					return(false);
				}
				return(true);
			default:
				trigger_error("Unsupported 'page'", E_USER_WARNING);
				return(false);
		}
	}//}}}
	
	function handle_post_request()
	{//{{{
		$action = @strval($_POST["action"]);
		switch($action) {
			case('test'):
				$return = $this->test();
				if($return !== true) {
					trigger_error("Can't perform 'test' action", E_USER_WARNING);
					return(false);					
				}
				return(true);
			default:
				trigger_error("Unsupported 'action'", E_USER_WARNING);
				return(false);
		}
	}//}}}
	
	function main()
	{//{{{
		$url_path = htmlentities($this->url_path);
		$csrf_token = htmlentities($this->csrf_token);
		
		HTML::$body .= 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
<fieldset>
	<legend>Get main page</legend>
	<form action="{$url_path}" method="post">
		<input name="csrf_token" value="{$csrf_token}" type="hidden" />
		<button name="action" value="test" type="submit">Test action</button>
	</from>
</fieldset>
HEREDOC;
////////////////////////////////////////////////////////////////////////////////

		return(true);
	}//}}}

	function test()
	{//{{{
		$csrf_token = @strval($_POST['csrf_token']);
		if(strcmp($this->csrf_token, $csrf_token) !== 0) {
			trigger_error("Compare csrf_tokens failed", E_USER_ERROR);
		}
		
		$url_path = htmlentities($this->url_path);
		
		HTML::$body .=
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
<fieldset>
	<legend>Post test action</legend>
	<a href="{$url_path}"><button>To main</button></a>
</fieldset>
HEREDOC;
////////////////////////////////////////////////////////////////////////////////
		
		return(true);
	}//}}}

}

