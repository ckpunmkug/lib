<?php

function form(
	string $action,
	string $elements,
	string $attributes = ''
) {
	$action = htmlentities($action);

	if(!defined('CSRF_TOKEN')) {
		trigger_error("CSRF_TOKEN not defined", E_USER_ERROR);
		exit(255);
	}
	$csrf_token = htmlentities(CSRF_TOKEN);
	
	$attributes = trim($attributes);
	
	$html = 
////////////////////////////////////////////////////////////////////////////////
<<<HEREDOC
<form
	action="{$action}"
	method="post"
	enctype="multipart/form-data"
	accept-charset="UTF-8"
	autocapitalize="off"
	autocomplete="off"
	novalidate
{$attributes}
	>
	<input name="csrf_token" value="{$csrf_token}" type="hidden" />
{$elements}
</form>

HEREDOC;
////////////////////////////////////////////////////////////////////////////////

	return($html);
}

