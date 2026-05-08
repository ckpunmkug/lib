window.addEventListener("keydown", function(event) {
	var $return;
	//console.log(event);
	if(
		event.altKey == false
		&& event.ctrlKey == false
		&& event.metaKey == false
		&& event.shiftKey == false
	) {
		switch(event.key) {
			case('F1'):
			containers.switchToView(1);
			break;
			
			case('F2'):
			containers.switchToView(2);
			break;
			
			case('Tab'):
			if(display.activeContainer == display.containers["form"]) {
				display.containers["tree"].focus();
				break;
			}
			if(display.activeContainer == display.containers["tree"]) {
				display.containers["form"].focus();
				break;
			}
			break;
			
			default:
			return(true);
		}
		
		event.preventDefault();
		event.stopPropagation();
		return(true);
	}
});
