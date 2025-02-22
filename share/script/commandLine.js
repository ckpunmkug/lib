// Usage
/*{{{

async function windowOnLoad(event)
{
	console.log(await commandLine());
}
window.addEventListener("load", windowOnLoad);

}}}*/

function commandLine()
{//{{{//

	$result = new Promise(function(resolve) {
		var $return;
		
		$return = document.querySelector("div[name='ckpunmkug.commandLine.container']");
		if($return !== null) {
			return(null);
		}
		
		var $container = document.createElement("div");
		$container.setAttribute('name', 'ckpunmkug.commandLine.container');
		
		var $style = {
			'all': 'unset'
			,'display': 'block'
			,'position': 'absolute'
			,'top': '0px'
			,'left': '0px'
			,'width': 'calc(100% - 12px)'
			,'margin': '4px'
			,'border': 'solid 2px black'
		};
		for(var [$key, $value] of Object.entries($style)) {
			$container.style.setProperty($key, $value);
		}
		
		$container.innerHTML = ''
///////////////////////////////////////////////////////////////{{{//
+`
<input name="commandline" value="" type="text" style="
	all: unset;
	width: calc(100% - 12px);
	font-family: Monospace;
	font-size: 16px;
	line-height: 24px;
	padding: 4px;
	background: black;
	color: white;
	border: solid 2px white;
	" />
`;
///////////////////////////////////////////////////////////////}}}//
		$container = document.body.appendChild($container);
		
		$input = $container.querySelector("input");
		$input.focus();
		
		var inputOnChange = function($input, $container, resolve) {
			var $result = $input.value;
			var $parent = $container.parentNode;
			$parent.removeChild($container);
			resolve($result);
		};
		
		$input.addEventListener("change", inputOnChange.bind(null, $input, $container, resolve));
	});

	return($result);
	
}//}}}//

