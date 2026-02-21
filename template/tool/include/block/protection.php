<?php

header("Content-Security-Policy: frame-ancestors 'self';");

session_set_cookie_params([
	'lifetime' => 3600,
	'path' => "/",
	'domain' => null,
	'secure' => false,
	'httponly' => true,
	'samesite' => 'Strict'
]);
session_start();

if(!(
	isset($_SESSION["csrf_token"]) 
	&& is_string($_SESSION["csrf_token"])
)) {
	$string = session_id() . uniqid('', true);
	$_SESSION["csrf_token"] = hash('sha256', $string);
	unset($string);
}
define('CSRF_TOKEN', $_SESSION["csrf_token"]);

