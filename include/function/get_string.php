<?php

function get_string(string $name)
{
	$result = "";

	$pattern = '/^([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(.*)$/';
	if(preg_match($pattern, $name, $MATCH) == 1) {
		$name = $MATCH[1];
		$keys = $MATCH[2];
		$result .=
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
if(defined('{$name}') == false) {
	trigger_error('{$name} is not defined', E_USER_WARNING);
	return(false);
}

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		goto next_label;
	}

	$pattern = '/^(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(.*)$/';
	if(preg_match($pattern, $name, $MATCH) == 1) {
		$name = $MATCH[1];
		$keys = $MATCH[2];
		$result .=
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
if(isset({$name}) == false) {
	trigger_error('{$name} is not set', E_USER_WARNING);
	return(false);
}

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		goto next_label;
	}
	
	trigger_error("Incorrect name passed", E_USER_WARNING);
	return("return(false);");
	
	next_label:
	
	$pattern = '/\["([a-zA-Z0-9_\x7f-\xff]+)"\]/';
	$count = preg_match_all($pattern, $keys, $MATCH);
	
	if($count == 0) {
		$result .= 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
if(is_string({$name}) == false) {
	trigger_error('{$name} is not string', E_USER_WARNING);
	return(false);
}
return({$name});

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		return($result);
	}
	else {
		$keys = $MATCH[1];
		foreach($keys as $key) {
			$result .= 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
if(is_array({$name}) == false) {
	trigger_error('{$name} is not array', E_USER_WARNING);
	return(false);
}

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
			$string = "{$name}[\"{$key}\"]";
			$result .= 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
if(key_exists('{$key}', $name) == false) {
	trigger_error('{$string} not exists', E_USER_WARNING);
	return(false);
}

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
			$name = $string;
		}
		$result .= 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
if(is_string({$name}) == false) {
	trigger_error('{$name} is not string', E_USER_WARNING);
	return(false);
}
return({$name});

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
	}
	return($result);
}

