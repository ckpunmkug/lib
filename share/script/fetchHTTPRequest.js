function fetchHTTPRequest($input, $options)
{//{{{//
	var $Request = new Request($input, $options);
	
	// fetch
	
	try {
		var $Response = await fetch($Request);
	}
	catch($error) {
		console.error("Can't fetch given URL");
		console.error($error);
		return(false);
	}
	
	// get status 
	
	try {
		var $status = $Response.status;
		if(!(
			typeof($status) == 'number'
			&& $status !== NaN
		)) {
			console.error("Incorrect status in Response");
			return(false);
		}
	}
	catch($error) {
		console.error("Can't get status from Response");
		console.error($error);
		return(false);
	}
	
	// get headers
	
	try {
		var $headers = $Response.headers;
		if(!(
			typeof($headers) == "object" 
			&& ($headers instanceof Headers)
		)) {
			console.error("Incorrect headers object in Response");
			return(false);
		}
	}
	catch($error) {
		console.error("Can't get headers from Response");
		console.error($error);
		return(false);
	}
	
	// is body readable stream and not lock
	
	try {
		var $ReadableStream = $Response.body;
		if(!(
			typeof($ReadableStream) == "object"
			&& $ReadableStream.constructor.name == "ReadableStream"
		)) {
			console.error("Response.body is not ReadableStream");
			return(false);
		}
		if(!($ReadableStream.locked == false)) {
			console.error("Response.body ReadableStream is locked");
			return(false);
		}
	}
	catch($error) {
		console.error("Can't use ReadableStream given from Response.body");
		console.error($error);
	}
	
	// get chunks from Response.body
	
	var $body = "";
	var $chunk = "";
	
	for await ($chunk of $ReadableStream) {
		$body += new TextDecoder().decode($chunk);
	}
	
	return({
		status: $status
		,headers: $headers
		,body: $body
	});
}//}}}//

