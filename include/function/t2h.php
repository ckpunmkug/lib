<?php

function t2h(string $text)
{//{{{//
	
	$html = '';
	
	$text = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$text = preg_replace("/ /", '&nbsp;', $text);
	$text = preg_replace("/	/", '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $text);
	$text = nl2br($text);
	
	$html = $text;
	
	return($html);
	
}//}}}//

