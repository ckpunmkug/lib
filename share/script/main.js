window.E_USER_WARNING = 512;
window.E_USER_ERROR = 256;

function trigger_error($error_string, $error_type)
{//{{{//
	
	switch($error_type) {
	
		case(E_USER_WARNING):
		console.warn($error_string);
		return(true);
		
		case(E_USER_ERROR):
		alert($error_string);
		throw new Error($error_string);
		return(true);
		
	}// switch($error_type)
	
	return(false);
	
}//}}}//

function defined($constant_name)
{//{{{//
	
	if(window[$constant_name] === undefined) return(false);
	return(true);
	
}//}}}//

function var_dump($variable)
{//{{{//
	
	console.debug($variable);
	return(true);
	
}//}}}//

function exit($status)
{//{{{//
	
	throw new Error("Script exited with status - " + $status);
	return(false);
	
}//}}}//
function die($status) { exit($status); }

async function main(event)
{//{{{//
	
	var $inputs = ["input[type='text']", "input[type='password']", "textarea"];
	for(let $key in $inputs) {
		$NodeList = document.querySelectorAll($inputs[$key]);
		for(let $index = 0; $index < $NodeList.length; $index += 1) {
			let element = $NodeList[$index];
			element.setAttribute("autocomplete", "off");
			element.setAttribute("spellcheck", "false");
		}
	}
	
}//}}}//
window.addEventListener("load", main);
