<?php

class Page
{
	static function form_layout(string $content, string $name = '')
	{//{{{//
		
		$_ = [];
		
		$_["csrf_token"] = t2h(CSRF_TOKEN);
		
		$_["name"] = '';
		if($name != '') {
			$_["name"] = 'name="'.t2h($name).'"';
		}
		
		$form = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<form {$_['name']} action="index.php" method="post" enctype="multipart/form-data">
	<input name="csrf_token" type="hidden" value="{$_['csrf_token']}" />
{$content}
</form>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		return($form);
		
	}//}}}//

	static function index()
	{//{{{//
		
		$content = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<button name="action" value="complete" type="submit">Complete</button>
<button name="action" value="warning" type="submit">Warning</button>
<button name="action" value="error" type="submit">Error</button>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		$form = self::form_layout($content, "test");
		
		$containers = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<div id="container_a"><h3>Continer A</h3></div>
<div id="container_b"><h3>Continer B</h3></div>
<div id="container_c"><h3>Continer C</h3></div>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		$body = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<a href="index.php?page=warning">Warning</a>
<a href="index.php?page=error">Error</a><br />
{$form}
{$containers}
<label>
	<input type="checkbox" />
	Select this
</label>
<input id="data_string" type="text" />

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		HTML::$title = "Index";
		HTML::$body = $body;
		
		return(true);
		
	}//}}}//

	static function warning()
	{//{{{//
		
		trigger_error("Test warning 1", E_USER_WARNING);
		trigger_error("Test warning 2", E_USER_WARNING);
		trigger_error("Test warning 3", E_USER_WARNING);
		
		if(defined('DEBUG') && DEBUG) var_dump(['$_GET' => $_GET]);
		trigger_error("Warning with debug", E_USER_WARNING);
		
		$body = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text Body text<br />
HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		HTML::$title = 'Warning';
		HTML::$body = $body;
		
		return(true);
		
	}//}}}//

	static function error()
	{//{{{//
		
		if(UNDEFINED){}
		return(true);
		
	}//}}}//
}

