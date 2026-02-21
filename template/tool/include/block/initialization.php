<?php

if(defined('QUIET') && QUIET === true) {
	ini_set('error_reporting', 0);
	ini_set('display_errors', '0');
}
else {
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', '1');
	ini_set('html_errors', '0');
}

ob_start(function($buffer) {
	$buffer = htmlentities($buffer);
	return(<<<HEREDOC
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
	<head>
	<body>
		<pre>{$buffer}</pre>
	</body>
</html>
HEREDOC);
});

