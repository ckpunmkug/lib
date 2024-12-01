<?php

class Page
{//{{{
	var $styles = [
		'/share/style/grey.css'
	];
	var $scripts = [];
	
	function __construct()
	{//{{{
		HTML::$styles = $this->styles;
		HTML::$scripts = $this->scripts;
	}//}}}

	function index()
	{//{{{
		$csrf_input = HTML::generate_csrf_input();
		$url_path = htmlentities(HTML::get_url_path());
		HTML::$body .= 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
<form action="{$url_path}" method="post">
	{$csrf_input}
	<button name="action" value="phpinfo" type="submit">PHPInfo</button>
</form>
HEREDOC;
////////////////////////////////////////////////////////////////////////////////
		return(true);
	}//}}}

}//}}}

