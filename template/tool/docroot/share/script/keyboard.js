window.addEventListener("keydown", function(event) {
	//console.log(event);
	if(
		event.altKey == false
		&& event.ctrlKey == false
		&& event.metaKey == false
		&& event.shiftKey == false
	) {
		switch(event.key) {
			case('F1'):
			alert("Help message");
			break;
			
			case('F2'):
			display.showContainer("container_a");
			break;
			
			case('F3'):
			display.showContainer("container_b");
			break;
			
			case('F4'):
			display.showContainer("container_c");
			break;
			
			default:
			return(true);
		}
		
		event.preventDefault();
		event.stopPropagation();
		return(true);
	}
});
