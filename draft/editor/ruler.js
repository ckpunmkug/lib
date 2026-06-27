var div;
function ruler(textarea, color) {
	if(!(
		textarea instanceof Element
		&& textarea.tagName == 'TEXTAREA'
	)) {
		throw new Error('Incorrect textarea passed into editorObject');
	}
	this.textarea = textarea;
	this.ch = 0;
	this.ruler = null;
	
	this.createRuler = function()
	{//{{{//
	
		this.ruler = document.createElement('DIV');
		
//		this.ruler.style.setProperty('all', 'unset');
		this.ruler.style.setProperty('display', 'block');
		
		this.textarea.after(this.ruler);
		
	};//}}}//
	
	this.getCh = function()
	{//{{{//
		
		var $computedStyle = getComputedStyle(this.textarea);
		this.ruler.style.setProperty(
			'font-family'
			,$computedStyle.getPropertyValue('font-family')
		);
		this.ruler.style.setProperty(
			'font-size'
			,$computedStyle.getPropertyValue('font-size')
		);
		
		this.ruler.style.setProperty('width', '1ch');
		var $clientRects = this.ruler.getClientRects();
		this.ch = $clientRects[0]["width"];
		
	};//}}}//
	
	this.giveShapeRuler = function()
	{//{{{//
		
		this.textarea.parentNode.style.setProperty('position', 'relative');
		this.ruler.style.setProperty('position', 'absolute');
		this.ruler.style.setProperty('top', '0px');
		this.ruler.style.setProperty('width', '0px');
		this.ruler.style.setProperty('height', '100%');
		
		var $left = 80 * this.ch;
		$left = $left.toString() + 'px';
		this.ruler.style.setProperty('left', $left);
		
		this.ruler.style.setProperty('border-right', '1px solid ' + color);
		
	}//}}}//
	
	this.animationFrame = null;
	
	this.textareaOnScroll = function(event)
	{//{{{//
	
		if(this.animationFrame !== null) return;
		this.animationFrame = requestAnimationFrame(this.translateX.bind(this));
		
	};//}}}//
	
	this.translateX = function()
	{//{{{//
		
		var $offset = 80 * this.ch - this.textarea.scrollLeft;
		$offset = $offset.toString() + "px";
		this.ruler.style.setProperty("left", $offset);
		
		this.animationFrame = null;
		
	};//}}}//
	
	this.createRuler();
	this.getCh();
	this.giveShapeRuler(color);
	
	this.textarea.addEventListener("scroll", this.textareaOnScroll.bind(this), { passive: true });
}

