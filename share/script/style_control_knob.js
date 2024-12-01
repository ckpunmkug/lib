// Style control knob - used to find the optimal value

function knobObject(
	configurable_element
	,style_property
	,unit
	,volume
	,step
) 
{//{{{
	this.html = 
/////////////////////////////////////////////////////////////////////////////{{{
`
<span name="style_property" style="all: initial;">XXXXXXXXXXXXXXXXXXXXXX</span>
<input name="volume" type="text" value="100" size="10" readonly style="all: initial;" />
<button name="decrement">-</button>
<button name="increment">+</button>
`;
/////////////////////////////////////////////////////////////////////////////}}}
	
	this.configurable_element = configurable_element;
	this.style_property = style_property;
	this.unit = unit;
	
	this.volume = volume;
	this.step = step;
	this.set = function(volume)
	{//{{{
		let value = String(volume) + this.unit;
		this.configurable_element.style.setProperty(this.style_property, value);
		this.input.value = value;
	};//}}}
	this.increment = function(event)
	{//{{{
		this.volume += this.step;
		this.set(this.volume);
	}//}}}
	this.decrement = function(event)
	{//{{{
		this.volume -= this.step;
		this.set(this.volume);
	}//}}}
	
	this.container = document.createElement("div");
	
	let properties = [];
	let setProperties = function(element, properties)
	{//{{{
		for(let name in properties) {
			let value = properties[name];
			element.style.setProperty(name, value);
		}
	};//}}}
	
	this.container.innerHTML = this.html;
	this.container = configurable_element.insertAdjacentElement('afterend', this.container);
	
	properties = {
		"all": "initial"
		,"display": "inline-block"
		,"padding": "8px"
		,"margin": "6px"
		,"border": "solid 2px black"
		,"box-shadow": "0px 0px 0px 2px white"
		,"color": "#000"
		,"background": "#FFF"
	};
	setProperties(this.container, properties);
	
	this.input = this.container.querySelector("input[name='volume']");
	this.set(this.volume);
	
	let element;
	
	element = this.container.querySelector("button[name='increment']");
	element.addEventListener("click", this.increment.bind(this));
	
	element = this.container.querySelector("button[name='decrement']");
	element.addEventListener("click", this.decrement.bind(this));
	
	element = this.container.querySelector("span[name='style_property']");
	element.innerText = style_property + ":";
	
	return(null);	
}//}}}

if(!true) // TECT
{//{{{
	window.addEventListener("load", function(event) {
		let element = document.getElementById("currently_configurable_element");
		let knob = new knobObject(element, "font-size", "px", 10, 1);
	});
}//}}}
