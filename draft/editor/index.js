var $PLUGIN = {};

var submitter = {
	textarea: null,
	input: null,
	action: null,
};

var footer = {
	container: null,
	hint: null,
	line: null,
	
	initialization: function()
	{//{{{//
		
		this.container = document.querySelector('footer');
		this.container.style.setProperty('display', 'none');
		
		this.hint = document.getElementById('XX95');
		this.line = document.getElementById('2ZCU');
		
	},//}}}//
};

var action = {
	goToLine: function()
	{//{{{//
		
		/// Hide the footer if it was open /////////////////////////////
		
		var $return = footer.container.style.getPropertyValue('display');
		if($return == "block") {
			footer.container.style.setProperty('display', 'none');
			submitter.textarea.focus();
			return(true);
		}
		
		/// Get curent line ////////////////////////////////////////////
		
		var $currentLine, $currentPos;
		
		var $value = submitter.textarea.value;
		var $selectionStart = submitter.textarea.selectionStart;
		var $selectionEnd = submitter.textarea.selectionEnd;
		var $selectionDirection = submitter.textarea.selectionDirection;
		
		$currentPos = $selectionStart;
		if($selectionStart != $selectionEnd) {
			if($selectionDirection == 'forward') {
				$currentPos = $selectionEnd;
			}
		}
		
		$currentLine = 1;
		for(let $pos = 0; $pos < $value.length; $pos += 1) {
			if($pos == $currentPos) break;
			
			let $char = $value.substring($pos, $pos + 1);
			if($char == "\n") {
				$currentLine += 1;
			}
		}
		
		/// Display the footer as a 'Go to line' input field ///////////
		
		footer.hint.innerText = "Go to line";
		footer.line.value = $currentLine;
		footer.container.style.setProperty('display', 'block');
		footer.line.focus();
		submitter.input.select();
		
		return(true);
		
	}//}}}//
};

function windowOnKeyDown(event)
{//{{{//
	
	if(
		event.altKey == false
		&& event.ctrlKey == true
		&& event.metaKey == false
		&& event.shiftKey == false
	) {
		switch(event.key) {
			case('s'):
			case('ы'):
			event.preventDefault();
			event.stopPropagation();
			break;
			
			case('g'):
			case('п'):
			event.preventDefault();
			event.stopPropagation();
			action.goToLine();
			break;
		}
		return(true);
	}
	return(true);
	
}//}}}//
function windowOnLoad(event)
{//{{{//
	
	const textarea = document.getElementById("XV5G");
	
	var $ID = ['UP1G', '5IPC', 'XA89', 'FGFC'];
	for(let $i = 0; $i < $ID.length; $i += 1) {
		let $element = document.getElementById($ID[$i]);
		$element.parentElement.removeChild($element);
	}
	
	$PLUGIN["indent"] = new indent(textarea);
	$PLUGIN["ruler"] = new ruler(textarea, '#333');
	var $keywords = {
		"_D_": ['var_dump(); die;', 7],
		"ev": ["ev var_dump();", 2],
		"b": 'break ',
		"bd": 'break del ',
		"c": 'continue',
		"s": 'step',
		"t": 'back 1',
		"q": 'quit',
		"r": '#readline',
	};
	$PLUGIN["tabulation"] = new tabulation(textarea, $keywords);
	
	submitter.textarea = document.getElementById("XV5G");
	submitter.input = document.getElementById("2ZCU");
	submitter.action = document.getElementById("2ZCU");
	
	footer.initialization();
	
	window.addEventListener("keydown", windowOnKeyDown);
	submitter.input("keydown", submitter.
	
}//}}}//
window.addEventListener("load", windowOnLoad);

