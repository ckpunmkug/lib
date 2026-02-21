var tool = {
	windowOnLoad: function(event)
	{//{{{//
		
		var form = document.querySelector('form[name="test"]');
		form.addEventListener("submit", this.formOnSubmit.bind(this, form));
		
	},//}}}//
	
	formOnSubmit: async function(form, event)
	{//{{{//
		
		event.preventDefault();
		event.stopPropagation();
	
		var $object = await transceiver.send(form, event.submitter);
		if(typeof($object["output"]) == 'string') {
			console.log($object["output"]);
			alert("Action '"+$object["action"]+"' - complete with output\nLook this output at the console");
		}
		
		this.dataOnLoad($object["action"], $object["data"]);
		
	},//}}}//
	
	dataOnLoad: function($action, $data)
	{//{{{//
		
		var input = document.getElementById("data_string");
		input.value = "action = "+$action+", data = "+$data;
		
	},//}}}//
};

window.addEventListener("load", tool.windowOnLoad.bind(tool));
