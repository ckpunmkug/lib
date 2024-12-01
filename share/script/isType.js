// A set of type checking functions.

function /// Check is variable integer
isInteger($variable) // true || false
{//{{{
	if(typeof($variable) != 'number') {
		return(false);
	}
	
	try {
		$result = Number.isInteger($variable);
	}
	catch($Exception) {
		return(false);
	}
	
	return($result);
}

if(!true) // test
{
	window.addEventListener("load", function(){
		console.log(isInteger(37));
		console.log(isInteger(3.14));
		console.log(isInteger(Math.LN2));
		console.log(isInteger(Infinity));
		console.log(isInteger(NaN));
		console.log(isInteger(Number("1")));
		console.log(isInteger(Number("shoe")));
	});
}//}}}

function /// Check is variable string
isString($variable) // true || false
{//{{{
	if(typeof($variable) != 'string') {
		return(false);
	}
	
	return(true);
}

if(!true) // test
{
	window.addEventListener("load", function(){
		console.log(isString(null));
		console.log(isString(String(null)));
	});
}//}}}

function /// Check is variable object
isObject($variable) // true || false
{//{{{
	if(typeof($variable) != 'object') {
		return(false);
	}
	
	try {
		$result = $variable instanceof Object;
	}
	catch($Exception) {
		return(false);
	}
	
	return($result);
}

if(!true) // test
{
	window.addEventListener("load", function(){
		console.log(isObject(null));
		console.log(isObject([]));
		console.log(isObject({}));
		console.log(isObject("Text"));
		console.log(isObject(String("Text")));
	});
}//}}}

function /// Check is element HTMLElement
isElement($element) // true || false
{//{{{
	if(typeof($element) != 'object') {
		return(false);
	}
	
	try {
		$result = $element instanceof HTMLElement;
	}
	catch($Exception) {
		return(false);
	}
	
	return($result);
}

if(!true) // test
{
	window.addEventListener("load", function(){
		console.log(isElement(document.body));
		console.log(isElement(null));
	});
}//}}}

