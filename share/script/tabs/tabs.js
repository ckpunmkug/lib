var Tabs = {
	initialize: function()
	{//{{{//
		var $index, $length;
		
		this.BUTTON = document.querySelectorAll("button[class='tab']");
		this.IFRAME = document.querySelectorAll("iframe[class='tab']");
		
		this.closeAllTabs();
		
		$length = this.BUTTON.length;
		for($index = 0; $index < $length; $index += 1) {
			let $name = this.BUTTON[$index].getAttribute("name");
			this.BUTTON[$index].addEventListener("click", this.onButtonClick.bind(this, $name));
		}
		
		$length = this.IFRAME.length;
		for($index = 0; $index < $length; $index += 1) {
				this.IFRAME[$index].style.setProperty("width", "100%");
		}
		
		setInterval(this.resizeIFrames.bind(this), 0x100);
	}//}}}//
	
	,BUTTON: []
	,IFRAME: []
	,IFRAME_HEIGHT: []
	
	,closeAllTabs: function()
	{//{{{//
		var $index, $length;
		$length = this.IFRAME.length;
		for($index = 0; $index < $length; $index += 1) {
			this.IFRAME_HEIGHT[$index] = 0;
			this.IFRAME[$index].style.setProperty("display", "none");
		}
	}//}}}//
	
	,onButtonClick: function($name)
	{//{{{//
		var $return, $index, $length;
		
		this.closeAllTabs();
		
		$length = this.IFRAME.length;
		for($index = 0; $index < $length; $index += 1) {
			$return = this.IFRAME[$index].getAttribute("name");
			if($return == $name) {
				this.IFRAME[$index].style.setProperty("display", "block");
				return(true);
			}
		}
	}//}}}//
	
	,resizeIFrames: function()
	{//{{{//
		var $index, $length;
		$length = this.IFRAME.length;
		for($index = 0; $index < $length; $index += 1) {
			if(this.IFRAME[$index].style.display == "block") {
				var $clientRects = this.IFRAME[$index].contentDocument.body.getClientRects();
				var $height = $clientRects[0].top + $clientRects[0].bottom;
				
				if(this.IFRAME_HEIGHT[$index] != $height) {
					this.IFRAME[$index].style.setProperty("height", String($height)+"px");
					this.IFRAME_HEIGHT[$index] = $height;
				}
			}
		}
	}//}}}//
	
}

function windowOnLoad(event)
{
	Tabs.initialize();
	Tabs.onButtonClick("page1");
}
window.addEventListener("load", windowOnLoad);

