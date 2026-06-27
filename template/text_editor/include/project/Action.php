<?php

class Action
{
	static function open()
	{//{{{//
		
		if(!eval(Check::$string.='$_POST["path"]')) return(false);
		$path = trim($_POST["path"]);
			
		$return = FileSystem::is_file_rwx($path, true, false, false, false);
		if(!$return) {
			trigger_error("Incorrect given path", E_USER_WARNING);
			
			HTML::$body = '<a href="'. URL_PATH .'" autofocus>Back</a>';
			HTML::echo();
			
			return(true);
		}
		
		$_ = [
			"path" => urlencode($path),
		];
		header("Location: ".URL_PATH."?path={$_['path']}");
		
		return(true);
		
	}//}}}//
	
	static function save()
	{//{{{//
		
		if(!eval(Check::$string.='$_POST["path"]')) return(false);
		$path = $_POST["path"];
		
		if(!eval(Check::$string.='$_POST["text"]')) return(false);
		$text = $_POST["text"];
		
		$_ = ["path" => htmlentities($path)];
		
		$pattern = '/^\/.*$/';
		$return = preg_match($pattern, $path);
		if($return != 1) {
			$cwd = getcwd();
			$path = "file://{$cwd}/{$path}";
		}
		else {
			$path = "file://{$path}";
		}
		
		$return = '';
		$length = strlen($text);
		for($offset = 0; $offset < $length; $offset += 1) {
			$char = substr($text, $offset, 1);
			$ord = ord($char);
			if($ord != 0x0D) $return .= $char;
		}
		$text = $return;
		
		$return = file_put_contents($path, $text);
		if(!is_int($return)) {
			if(defined('DEBUG') && DEBUG) var_dump(['$path' => $path]);
			trigger_error("Can't put contents to file", E_USER_WARNING);
			return(false);
		}
		$bytes = $return;
		
		$_["bytes"] = strval($bytes);
		
		$body = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
{$_["bytes"]} bytes saved in {$_["path"]}

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		HTML::$title = 'complete'; // iframe.contentDocument.title
		HTML::$body = $body;
		HTML::echo();
		
		return(true);
		
	}//}}}//
}

