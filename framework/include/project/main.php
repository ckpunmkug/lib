<?php

if(true) // ArgV
{//{{{//

	ArgV::$description = "Program description";
	ArgV::apply($argv);
	
	// Examples
	/* {{{
		ArgV::add([
			"-a", "--A", NULL, "not required parameter",
			function () {
				define("A", true);
			}, false
		]);
		ArgV::add([
			"-b", "--B", NULL, "required parameter",
			function () {
				define("B", true);
			}, true
		]);
		ArgV::add([
			"-c", "--C", "STRING", "not required parameter with value",
			function ($string) {
				define("C", $string);
			}, false
		]);
		ArgV::add([
			"-d", "--D", "STRING", "required parameter with value",
			function ($string) {
				define("D", $string);
			}, true
		]);
		ArgV::add([
			"-first", NULL, NULL, "middle name not required parameter",
			function () {
				define("FIRST", $string);
			}, false
		]);
		ArgV::add([
			NULL, "--second", "STRING", "middle name required parameter with value",
			function ($string) {
				define("SECOND", $string);
			}, true
		]);
		ArgV::add([
			"--without-description", NULL, NULL, NULL,
			function ($string) {
				define("SECOND", $string);
			}, true
		]);
	}}} */
	
}//}}}//

function main(array $argv)
{
	
	return(true);	
	
}
