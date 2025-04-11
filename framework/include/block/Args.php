<?php

Args::$description = PROJECT_NAME." - is a ....";

Args::add([
	"-i", "--install", NULL, "Install required files into home directory",
	function () {
		define("ACTION", "install");
	}, false
]);

Args::apply();

