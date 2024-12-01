function windowOnLoad(event)
{//{{{//
	var button = document.querySelector("button");
	button.addEventListener("click", function() {
		var element = document.createElement("div");
		element = document.body.appendChild(element);
		element.style.setProperty("background", "#000");
		element.style.setProperty("width", "800px");
		element.style.setProperty("height", "600px");
	});
}//}}}//

window.addEventListener("load", windowOnLoad);
