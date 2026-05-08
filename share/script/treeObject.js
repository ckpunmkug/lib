function treeObject(ul)
{
	if(!( ul instanceof Element && ul.tagName == "UL" )) {
		throw new Error('Incorrect ul passed into treeObject');
	}
	this.container = ul;
	this.container.tabIndex = "-1";
//	this.container.addEventListener("focus", this.containerOnFocus.bind(this));

/// Items //////////////////////////////////////////////////////////////////////

	this.items = {}; // item["id"] = [ "parent", "content", li = [ span, ul ] ]
	
	this.itemOnClick = function($span, event)
	{//{{{//
		
		$span.classList.replace("blur", "focus");
		var $id = $span.parentNode.getAttribute("id");
		
		if(this.activeItem != "") {
			$span= this.items[this.activeItem][2].childNodes[0];
			$span.classList.replace("focus", "blur");
		}
		
		this.activeItem = $id;
		
		return(true);
		
	};//}}}//
	
	this.addItem = function($parent, $content)
	{//{{{//
		
		if(typeof($parent) != "string") {
			console.warn("parent is not string");
			return(false);
		}
		
		if(typeof($content) != "string") {
			console.warn("content is not string");
			return(false);
		}
	
		var $id = Math.random().toString(36).substring(2, 6);
		var $li = document.createElement("li");
		$li.setAttribute("id", $id);
		
		var $span = document.createElement("span");
		$span.innerText = $content;
		$li.appendChild($span);
		
		var $ul = document.createElement("ul");
		$li.appendChild($ul);
		
		this.items[$id] = [];
		this.items[$id][0] = $parent;
		this.items[$id][1] = $content;
		
		if($parent == "") {
			this.items[$id][2] = this.container.appendChild($li);
		}
		else {
			this.items[$id][2] = this.items[$parent][2].childNodes[1].appendChild($li);
		}
		
		$span = this.items[$id][2].childNodes[0];
		$span.classList.add("blur");
		$span.addEventListener("click", this.itemOnClick.bind(this, $span));
		
		return($id);
		
	};//}}}//
	
	this.deleteItem = function($id, $isChild = false)
	{//{{{//
		
		if(typeof($id) != "string") {
			console.warn("id is not string");
			return(false);
		}
	
		var $parent = $id;
		for($id in this.items) {
			if(this.items[$id] === null) continue;
			if(this.items[$id][0] == $parent) {
				this.deleteItem($id, true);
			}
		}
		$id = $parent;
		
		$parent = this.items[$id][0];
		if($parent == "") {
			this.container.removeChild(this.items[$id][2]);
		}
		else {
			this.items[$parent][2].childNodes[1].removeChild(this.items[$id][2]);
		}
		this.items[$id] = null;
		
		if($isChild === false) {
			let items = {};
			for($id in this.items) {
				if(this.items[$id] === null) continue;
				items[$id] = this.items[$id];
			}
			this.items = items;
		}
		
		return(true);
	
	};//}}}//

/// Id /////////////////////////////////////////////////////////////////////////
	
	this.getPreviousChildId = function($current)
	{//{{{//
		
		var $parent = this.items[$current][0];
		var $previous = "";
		
		for(let $id in this.items) {
			if(this.items[$id][0] != $parent) continue;
			if($id == $current) break;
			$previous = $id;
		}
		
		return($previous);
		
	};//}}}//
	
	this.getNextChildId = function($current)
	{//{{{//
		
		var $parent = this.items[$current][0];
		var $previous = "";
		var $next = "";
		
		for(let $id in this.items) {
			if(this.items[$id][0] != $parent) continue;
			if($previous != "") {
				$next = $id;
				break;
			}
			if($id == $current) {
				$previous = $id;
			}
		}
		
		return($next);
		
	};//}}}//

	this.getParentId = function($child)
	{//{{{//
		
		var $parent = this.items[$child][0];
		return($parent);
		
	};//}}}//
	
	this.getFirstChildId = function($parent)
	{//{{{//
		
		var $child = "";
		for(let $id in this.items) {
			if(this.items[$id][0] == $parent) {
				$child = $id;
				break;
			}
		}
		return($child);
		
	};//}}}//

/// Keyboard ///////////////////////////////////////////////////////////////////
	
	this.activeItem = "";
	
	this.containerOnKeyDown = function(event)
	{//{{{//
		
		if(event.altKey == false && event.ctrlKey == false && event.metaKey == false && event.shiftKey == false) {
			//console.log(event.key);
			switch(event.key) {
				case('ArrowUp'):
				this.onArrowUp();
				break;
				
				default:
				return(true);
			}
			event.preventDefault();
			event.stopPropagation();
			return(true);
		}
		
	};//}}}//
	
	this.container.addEventListener("keydown", this.containerOnKeyDown.bind(this));
	
	this.onArrowUp = function()
	{//{{{//
		
		if(this.activeItem == "") return(true);
		
		var $current = this.activeItem;
		var $previous = this.getPreviousChildId($current);
		if($previous == "") return(true);
		
		var $span = this.items[$current][2].childNodes[0];
		$span.classList.replace("focus", "blur");
		
		$span = this.items[$previous][2].childNodes[0];
		$span.classList.replace("blur", "focus");
		
		this.activeItem = $previous;
		
		return(true);
	
	};//}}}//
}

