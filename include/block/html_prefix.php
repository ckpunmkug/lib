<?php

ob_start(function($ob) {
	$ob = htmlentities($ob);
	return(<<<HEREDOC
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
	<head>
	<style>
body {
	background: white;
	color: black;
}
	</style>
	<body>
		<pre>{$ob}</pre>
	</body>
</html>
HEREDOC);
});

ini_set('html_errors', '0');

