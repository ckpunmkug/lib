<?php

header("X-Frame-Options: SAMEORIGIN");
header("Content-Security-Policy: frame-ancestors 'self';");

if(
	isset($_SERVER["HTTP_SEC_FETCH_SITE"])
	&& is_string($_SERVER["HTTP_SEC_FETCH_SITE"])
) {
	if(
		$_SERVER["HTTP_SEC_FETCH_SITE"] != 'same-origin'
		&& $_SERVER["HTTP_SEC_FETCH_SITE"] != 'none'
	) {
		http_response_code(403);
		throw new Exception("Incorrect Sec-Fetch-Site header");
		exit(255);
	}
}

elseif(
	isset($_SERVER["HTTP_REFERER"])
	&& is_string($_SERVER["HTTP_REFERER"])
) {
	if(!(
		isset($_SERVER["REQUEST_SCHEME"])
		&& is_string($_SERVER["REQUEST_SCHEME"])
		&& isset($_SERVER["SERVER_NAME"])
		&& is_string($_SERVER["SERVER_NAME"])
		&& isset($_SERVER["SERVER_PORT"])
		&& is_string($_SERVER["SERVER_PORT"])
	)) {
		throw new Exception('Incorrect $_SERVER array');
		exit(255);
	}
	$scheme = $_SERVER["REQUEST_SCHEME"];
	$host = $_SERVER["SERVER_NAME"];
	$port = '';
	if($_SERVER["SERVER_PORT"] != '80' && $_SERVER["SERVER_PORT"] != '443') {
		$port = intval($_SERVER["SERVER_PORT"]);
	}
	$referer = parse_url($_SERVER["HTTP_REFERER"]);
	if(!isset($referer['port'])) {
		$referer['port'] = '';
	}
	if(!(
		$scheme == $referer['scheme']
		&& $host == $referer['host']
		&& $port == $referer['port']
	)) {
		http_response_code(403);
		throw new Exception('Incorrect $_SERVER["HTTP_REFERER"]', E_USER_ERROR);
		exit(255);
	}
}

else {
	$html = 
<<<HEREDOC
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
		Autostart is blocked. Follow the <a href="index.php">link</a>
	</body>
</html>
HEREDOC;
	echo($html);
	exit(0);
}

