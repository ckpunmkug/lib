function tabulation(textarea, keywords) {
	if(!(
		textarea instanceof Element
		&& textarea.tagName == "TEXTAREA"
	)) {
		throw new Error('Incorrect textarea passed into editorObject');
	}
	this.textarea = textarea;
	this.keywords = keywords;
	
	this.textareaOnKeyDown = function(event)
	{//{{{//
	
		if(
			event.altKey == false
			&& event.ctrlKey == false
			&& event.metaKey == false
			&& event.shiftKey == false
		) {
			switch(event.key) {
				case('Tab'):
				event.preventDefault();
				event.stopPropagation();
				this.tabKeyDownHandler();
				break;
			}
			return(true);
		}
		return(true);
		
	};//}}}//

	this.tabKeyDownHandler = function()
	{//{{{//
		
		var $value = this.textarea.value;
		var $selectionStart = this.textarea.selectionStart;
		var $selectionEnd = this.textarea.selectionEnd;
		
		/// Replace the selection with a tab character /////////////////
		
		if($selectionStart != $selectionEnd) {
			this.textarea.value = 
				$value.substring(0, $selectionStart)
				+ "\t" +
				$value.substring($selectionEnd)
			;
			this.textarea.selectionStart = $selectionStart + 1;
			this.textarea.selectionEnd = this.textarea.selectionStart;
			
			return(true);
		}
		
		/// Find the left side of the line /////////////////////////////
		
		var $currentPosition = $selectionStart;
		var $leftSide = '';
		while(true) {
			
			$currentPosition -= 1;
			if($currentPosition < 0) break;
			
			var $char = $value.substring($currentPosition, $currentPosition + 1);
			if(
				$char == "\n"
				|| $char == "\t"
				|| $char == " "
			) break;
			
			$leftSide = $char + $leftSide;
			
		} // while(true)
		
		/// Insert a tad character if left side is not a keyword ///////
		
		if(Object.hasOwn(this.keywords, $leftSide) !== true) {
			this.textarea.value = 
				$value.substring(0, $selectionStart)
				+ "\t" +
				$value.substring($selectionEnd)
			;
			this.textarea.selectionStart = $selectionStart + 1;
			this.textarea.selectionEnd = this.textarea.selectionStart;
			
			return(true);
		}
		
		/// Replace the left side with a keyword ///////////////////////
		
		var $item = this.keywords[$leftSide];
		
		if(typeof($item) == 'object') {
			this.textarea.value = 
				$value.substring(0, $selectionStart - $leftSide.length)
				+ $item[0] +
				$value.substring($selectionEnd)
			;
			this.textarea.selectionStart = $selectionStart - $leftSide.length + $item[0].length - $item[1];
			this.textarea.selectionEnd = this.textarea.selectionStart;
			
			return(true);
		}
		
		if(typeof($item) == 'string') {
			this.textarea.value = 
				$value.substring(0, $selectionStart - $leftSide.length)
				+ $item +
				$value.substring($selectionEnd)
			;
			this.textarea.selectionStart = $selectionStart - $leftSide.length + $item.length;
			this.textarea.selectionEnd = this.textarea.selectionStart;
			
			return(true);
		}
		
	};//}}}//
	
	this.textarea.addEventListener("keydown", this.textareaOnKeyDown.bind(this));
}

