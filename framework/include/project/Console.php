<?php

class Console
{
	static function test(string $abcd, int $N = 0, float $pi = 3.14)
	{//{{{//
		
		var_dump($abcd, $N, $pi);
		return(true);
		
	}//}}}//
	
	static function super()
	{//{{{//
	
		echo("XA!");
		
		return(true);
		
	}//}}}//
	
}
