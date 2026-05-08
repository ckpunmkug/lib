var transceiver = {
	timeout: 30, // in seconds
	maxResponseLength: 16, // in megabytes

	send: async function(form, submitter)
	{//{{{//
		
		var $FormData = new FormData(form, submitter);
		var $URL = form.getAttribute("action");
		
		var $return = await this.loader($URL, $FormData);
		if(typeof($return) != 'object') {
			trigger_error("Can't send form to server", E_USER_ERROR);
			exit(255);
		}
		var $response = $return;
		
		if($response["status"] == 201) {
			var $object;
			try {
				$object = JSON.parse($response["body"]);
			} 
			catch($error) {
				trigger_error($error, E_USER_WARNING);
				trigger_error("Can't parse server json answer", E_USER_ERROR);
				exit(255);
			} 
			return($object);
		}
		
		if($response["status"] == 200) {
			trigger_error("The server returned HTML, not JSON", E_USER_ERROR);
			exit(255);
		}
		
		trigger_error("Unknown server error", E_USER_ERROR);
		exit(255);
		
	},//}}}//

	loader: async function($URL, $FormData)
	{//{{{//
	
		var $url = $URL;
		var $data = $FormData;
		var $method = "POST";
		var $timeout = this,timeout;
		var $maxResponseLength = this.maxResponseLength;
		
		var wrapper = function($method, $url, $data, $timeout, $maxResponseLength, resolve, reject) {
			
			$maxResponseLength = 0x100000 * $maxResponseLength;
			$timeout = 1000 * $timeout;
			
			var $XMLHttpRequest = new XMLHttpRequest();
			$XMLHttpRequest.open($method, $url, true);	
			$XMLHttpRequest.responseType = "text";
			$XMLHttpRequest.timeout = $timeout;
		
			var onLoad = function($XMLHttpRequest, $maxResponseLength, resolve, onAbort) {
				if($XMLHttpRequest.response.length > $maxResponseLength) {
					$XMLHttpRequest.abort();
					onAbort(resolve);
				}
				$result = {
					status: $XMLHttpRequest.status,
					headers: $XMLHttpRequest.getAllResponseHeaders(),
					body: $XMLHttpRequest.response,
				};
				resolve($result);
			};
			
			var onProgress = function($XMLHttpRequest, $maxResponseLength, resolve, onAbort, event) {
				var $loaded = event.loaded;
				if($loaded > $maxResponseLength) {
					$XMLHttpRequest.abort()
					onAbort(resolve);
				}
			};
			
			var onAbort = function(resolve) {
				console.warn("XHR aborted");
				resolve(false);
			};
			
			var onTimeout = function(resolve) {
				console.warn("XHR timeout");
				resolve(false);
			};
			
			var onError = function(resolve) {
				console.warn("XHR error");
				resolve(false);
			};
			
			$XMLHttpRequest.addEventListener('load', onLoad.bind(null, $XMLHttpRequest, $maxResponseLength, resolve, onAbort));
			$XMLHttpRequest.addEventListener('progress', onProgress.bind(null, $XMLHttpRequest, $maxResponseLength, resolve, onAbort));
			$XMLHttpRequest.addEventListener('abort', onAbort.bind(null, resolve));
			$XMLHttpRequest.addEventListener('timeout', onTimeout.bind(null, resolve));
			$XMLHttpRequest.addEventListener('error', onError.bind(null, resolve));
			
			$XMLHttpRequest.send($data);
		};
		var $result = new Promise(wrapper.bind(null, $method, $url, $data, $timeout, $maxResponseLength));
		return($result);
		
	}//}}}//
};

