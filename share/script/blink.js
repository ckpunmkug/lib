function blink($div = null)
{
	if($div !== null) {
		document.body.removeChild($div);
		return(null);
	}
	
	$div = document.createElement('div');
	var $styleProperties = {
		"all": 'unset',
		"display": 'block',
		"position": 'absolute',
		"top": '0px',
		"left": '0px',
		"width": '100%',
		"height": '100%',
		"z-index": '655535',
		"background": 'black',
	};
	
	for(let [$property, $value] of Object.entries($styleProperties)) {
		$div.style.setProperty($property, $value);
	}
	
	$div = document.body.appendChild($div);
	setTimeout(blink, 100, $div);
}

