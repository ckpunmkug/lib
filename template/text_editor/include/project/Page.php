<?php

class Page
{
	static $style = [
		"index" =>
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
body {
	all: unset;
	font-family: sans-serif;
	font-size: 1rem;
}
iframe {
	display: block;
	width: calc(100% - 2ch);
	height: 3lh;
	margin: 1ch 0;
}
button, input, a {
	font-family: sans-serif;
	font-size: 1rem;
}
textarea {
	display: block;
	width: calc(100% - 2ch);
	height: calc(100% - 1ch);
	font-family: monospace;
	font-size: 1rem;
}
#container {
	all: unset;
	display: grid;
	grid-template-rows: auto 1fr auto;
	position: absolute;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 100%;
	
	header {
		all: unset;
		display: flex;
		overflow: hidden;
		align-items: center;
		justify-content: center;
	}
	main {
		all: unset;
		display: flex;
		overflow: hidden;
		align-items: center;
		justify-content: center;
	}
	footer {
		all: unset;
		display: block;
		overflow: hidden;
	}
}
#stretch {
	display: flex;
	line-height: 3rem;
	padding: 0 1ch;
	
	.fixed {
		white-space: nowrap;
	}
	.flex {
		flex: 100%;
		input {
			width: calc(100% - 3ch);
			margin: 0 1ch;
		}
	}
}

HEREDOC,
///////////////////////////////////////////////////////////////}}}//
		
		"help" =>
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
body {
	font-family: sans-serif;
	font-size: 1rem;
}

HEREDOC,
///////////////////////////////////////////////////////////////}}}//
	];
	
	static $script = [
		"index" => 
///////////////////////////////////////////////////////////////{{{//
<<<'HEREDOC'
const ID = {
	"textarea" : 'XV5G',
	"input"	: '2ZCU',
	"form" : 'Z06L',
	"iframe" : '4WZI',
};

function windowOnLoad(event)
{//{{{//
	
	var $element;
	
	$element = document.getElementById(ID["textarea"]);
	$element.addEventListener("keydown", function(event) {
		if(
			event.altKey == false
			&& event.ctrlKey == false
			&& event.metaKey == false
			&& event.shiftKey == false
		) {
			switch(event.key) {
				case('Tab'):
				event.preventDefault();
				event.stopPropagation();
				event.target.setRangeText("\t");
				event.target.selectionStart += 1;
				break;
			}
			return(true);
		}
		return(true);
	});
	
	window.addEventListener("keydown", function(event) {
		if(
			event.altKey == false
			&& event.ctrlKey == true
			&& event.metaKey == false
			&& event.shiftKey == false
		) {
			switch(event.key) {
				case('s'):
				case('ы'):
				event.preventDefault();
				event.stopPropagation();
				
				var $element;
				
				$element = document.querySelector('input[name="action"]');
				$element.value = 'save';
				
				$element = document.getElementById(ID["form"]);
				$element.setAttribute('target', 'iframe');
				$element.submit();
				
				break;
			}
			return(true);
		}
		return(true);
	});
	
}//}}}//
window.addEventListener("load", windowOnLoad);

HEREDOC,
///////////////////////////////////////////////////////////////}}}//
	];

	static function index()
	{//{{{//
		
		$path = '';
		$text = '';
		
		if(@is_string($_GET["path"])) {
			$path = trim($_GET["path"]);
			
			$return = FileSystem::is_file_rwx($path, true, false, false, false);
			if(!$return) {
				trigger_error("Incorrect given path", E_USER_WARNING);
				return(false);
			}
			
			$text = file_get_contents($path);
			if(!is_string($text)) {
				if(defined('DEBUG') && DEBUG) var_dump(['$path' => $path]);
				trigger_error("Can't get contents from file in given path", E_USER_WARNING);
				return(false);
			}
		}
		
		$_ = [
			"text" => htmlentities($text),
			"autofocus" => 'autofocus',
		];
		if($path == '') $_["autofocus"] = '';
		$textarea = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<textarea
	name="text" id="XV5G" form="Z06L"
	cols="128" rows="36" {$_["autofocus"]} accesskey="t" tabindex="1"
	wrap="off" style="white-space: nowrap;" 
	autocapitalize="none" autocomplete="off" autocorrect="off" spellcheck="false"
>{$_["text"]}</textarea>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		$labels = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<span id="5IPC">
	<u>F</u>rame
</span>
<label for="XV5G" id="XA89">
	<u>T</u>ext
</label>
<label for="2ZCU" id="FGFC">
	<u>P</u>ath
</label>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		$_ = [
			"path" => htmlentities($path),
			"autofocus" => 'autofocus',
		];
		if($path != '') $_["autofocus"] = '';
		$input = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<input 
	name="path" value="{$_['path']}" type="text" id="2ZCU" form="Z06L"
	size="80" accesskey="p"  tabindex="2" {$_["autofocus"]}
	autocapitalize="none" autocomplete="off" autocorrect="off" spellcheck="false"
/>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		$_ = [
			"url_path" => htmlentities(URL_PATH),
		];
		
		$buttons = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<button 
	name="action" value="open" type="submit" id="I3P3" form="Z06L" 
	formtarget="_self" accesskey="o" tabindex="3"
><u>O</u>pen</button>

<button 
	name="action" value="save" type="submit" id="GVUN" form="Z06L"
	formtarget="iframe" accesskey="s" tabindex="4"
><u>S</u>ave</button>

<a href="{$_['url_path']}" id="0NUB"><button 
	id="TBUZ" accesskey="n" tabindex="5"
><u>N</u>ew</button></a>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		$iframe = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<iframe
	src="{$_['url_path']}?page=help" name="iframe" id="4WZI"
	width="1024" height="96" accesskey="f" tabindex="6"
></iframe>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//

		$elements = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<input name="action" value="" type="hidden" id="TWCW" />

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		$form = form(URL_PATH, $elements, 'id="Z06L"');

		$_ = [
			"url_path" => htmlentities(URL_PATH."?page=help"),
		];
		$anchors = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<a href="{$_['url_path']}" id="TCBK" accesskey="h" target="_blank"><u>H</u>elp</u></a>
HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		$body = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<div id="container">
	<header>
{$form}
{$iframe}
	</header>
	<main>
{$textarea}
	</main>
	<footer>
		<div id="stretch">
			<span id="XX95" class="fixed">
{$labels}
			</span>
			<span id="ZYL9" class="flex">
{$input}
			</span>
			<span id="UP1G" class="fixed">
{$buttons}
{$anchors}
			</span>
		</div>
	</footer>
</div>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//
		
		HTML::$title = "Text editor";
		
		HTML::$styles = [
		];
		if(count(HTML::$styles) == 0) {
			HTML::$style = self::$style["index"];
		}
		
		HTML::$scripts = [
		];
		if(count(HTML::$scripts) == 0) {
			HTML::$script = self::$script["index"];
		}
		
		HTML::$body = $body;
		HTML::echo();
		
		return(true);
		
	}//}}}//

	static function help()
	{//{{{//
		
		$body = 
///////////////////////////////////////////////////////////////{{{//
<<<HEREDOC
<div id="container">
	<h4>Hot keys</h4>
	<p>
	Alt+Shift+T - Text editor<br />
	Alt+Shift+P - Path to file<br />
	Alt+Shift+O - Open file<br />
	Alt+Shift+S - Save file<br />
	Ctrl+S - Save file<br />
	Alt+Shift+N - New file<br />
	Alt+Shift+F - Frame window<br />
	Alt+Shift+H - Help page<br />
	</p>
</div>

HEREDOC;
///////////////////////////////////////////////////////////////}}}//

		HTML::$title = "Help text editor";
		
		HTML::$styles = [
		];
		if(count(HTML::$styles) == 0) {
			HTML::$style = self::$style["index"];
		}

		HTML::$body .= $body;
		HTML::echo();
		
		return(true);
		
	}//}}}//
	
}
