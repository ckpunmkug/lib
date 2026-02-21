var display = {
	windowOnLoad: function($ID, event)
	{//{{{//
	
		for(let $key in $ID) {
			let $id = "" + $ID[$key];
			let element = document.getElementById($id);
			this.containers[$id] = element;
			
			let computedStyle = getComputedStyle(element);
			this.displays[$id] = computedStyle.display;
		}
		
		this.hideContainers();
		
	},//}}}//

	containers: {},
	displays: {},
	
	hideContainers: function()
	{//{{{//
	
		for(let $key in this.containers) {
			this.containers[$key].style.setProperty("display", "none");
		}
		
	},//}}}//
	
	showContainer: function($id)
	{//{{{//
		
		this.hideContainers();
		this.containers[$id].style.setProperty("display", this.displays[$id]);
		
	},//}}}//
};
window.addEventListener("load", display.windowOnLoad.bind(display, [
	"container_a", "container_b", "container_c"
]));

