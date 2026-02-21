<?php

class Action
{
	static function complete()
	{//{{{//
		
		return("complete data string");
		
	}//}}}//
	
	static function warning()
	{//{{{//
		
		file_get_contents('not_existed_file');
		return('warning data string');
		
	}//}}}//

	static function error()
	{//{{{//
		
		if(UNDEFINED){}
		return(true);
		
	}//}}}//
}

