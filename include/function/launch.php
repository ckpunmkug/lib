<?php

function launch(
	string $command,
	string $stdin = '',
	array $ENVIRONMENT = [],
	int $timeout = 30,
) { // array

	/*
		$result = [
			"status" => '',
			"stdout" => '',
			"stderr" => '',
		];
	*/
	
	$timeout *= 1000000;
	
	$std = [
		["pipe", "r"],
		["pipe", "w"],
		["pipe", "w"],
	];
	$PIPE = [];
	$cwd = getcwd();
	if(!is_string($cwd)) {
		trigger_error("Can't get current working directory", E_USER_WARNING);
		return(false);
	}
	
	$return = getenv('USER', true);
	if(is_string($return)) $ENVIRONMENT["USER"] = $return;
	
	$return = getenv('HOME', true);
	if(is_string($return)) $ENVIRONMENT["HOME"] = $return;
	
	$ENVIRONMENT["PWD"] = $cwd;
	
	$proc = proc_open($command, $std, $PIPE, $cwd, $ENVIRONMENT);
	if(!is_resource($proc)) {
		if (defined('DEBUG') && DEBUG) var_dump(['$command' => $command]);
		trigger_error("Can't open process for command", E_USER_WARNING);
		return(false);
	}
	
	$strlen = strlen($stdin);
	$return = fwrite($PIPE[0], $stdin);
	if(!is_int($return)) {
		trigger_error("Can't write data to stdin", E_USER_WARNING);
		return(false);
	}
	if($return != $strlen) {
		trigger_error("Can't write full data to stdin", E_USER_WARNING);
		return(false);
	}	
	fclose($PIPE[0]);
	
	$stdout = '';
	$stderr = '';
	stream_set_blocking($PIPE[1], false);
	stream_set_blocking($PIPE[2], false);
	
	$kill_proc_group = function(int $parent_pid)
	{//{{{//
		
		$PID = [];
		array_push($PID, $parent_pid);
		
		$NAME = scandir('/proc');
		if(!is_array($NAME)) {
			trigger_error("Can't scan /proc dir", E_USER_WARNING);
			return(false);
		}
		
		for($index = 0; $index < count($PID); $index += 1) {
		
			$curent_pid = $PID[$index];
		
			foreach($NAME as $name) {
			
				$return = preg_match('/^\d+$/', $name);
				if($return != 1) continue;
				
				$path = "/proc/{$name}/stat";
				if(!(
					is_file($path)
					&& is_readable($path)
				)) continue;
				
				$stat = file_get_contents($path);
				if(!is_string($stat)) {
					trigger_error("Can't get contents of 'stat' file", E_USER_WARNING);
					return(false);
				}
				
				$pattern = '/^\d+\s+\(.+\)\s+([^\)]+)$/';
				$return = preg_match($pattern, $stat, $MATCH);
				if($return != 1) {
					trigger_error("Can't parse command from process stat", E_USER_WARNING);
					return(false);
				}
				$string = $MATCH[1];
				
				$pattern = '/^\S+\s+(\d+)\s+.+$/';
				$return = preg_match($pattern, $string, $MATCH);
				if($return != 1) {
					trigger_error("Can't parse parent pid from process stat", E_USER_WARNING);
					return(false);
				}
				$parent_pid = intval($MATCH[1]);
				
				if($parent_pid != $curent_pid) continue;
				
				$parent_pid = intval($name);
				
				array_push($PID, $parent_pid);
				
			} // foreach($NAME as $name)
			
		} // for($index = 0; $index < count($PID); $index += 1)
		
		while(true) {
			$pid = array_pop($PID);
			if(!is_int($pid)) break;
			
			posix_kill($pid, 9);
		}
		
		return(true);
		
	};//}}}//
	
	while(true) {//
		$proc_status = proc_get_status($proc);
		if(!is_array($proc_status)) {
			if (defined('DEBUG') && DEBUG) var_dump(['$command' => $command]);
			trigger_error("Can't get process status for command", E_USER_WARNING);
			return(false);
		}
		
		if($proc_status["running"] == false) break;
		
		$stdout .= stream_get_contents($PIPE[1]);
		$stderr .= stream_get_contents($PIPE[2]);
	
		usleep(100000);
		$timeout -= 100000;
		
		if($timeout <= 0) {
			$return = $kill_proc_group($proc_status["pid"]);
			if(!$return) {
				proc_terminate($proc, 9);
				trigger_error("Can't send SIGKILL to proc group", E_USER_WARNING);
			}
			
			foreach($PIPE as $pipe) {
				if(!is_resource($pipe)) continue;
				fclose($pipe);
			}
			proc_close($proc);
			
			if (defined('DEBUG') && DEBUG) var_dump(['$command' => $command]);
			trigger_error("Process with command timeout", E_USER_WARNING);
			return(false);
		}
	}// while(true)
	
	$result = [
		"status" => $proc_status["exitcode"],
	];
	
	$contents = stream_get_contents($PIPE[1]);
	if(!is_string($contents)) {
		if (defined('DEBUG') && DEBUG) var_dump(['$command' => $command]);
		trigger_error("Can't get command stdout contents", E_USER_WARNING);
		return(false);
	}
	$result["stdout"] = $stdout.$contents;
	fclose($PIPE[1]);
	
	$contents = stream_get_contents($PIPE[2]);
	if(!is_string($contents)) {
		if (defined('DEBUG') && DEBUG) var_dump(['$command' => $command]);
		trigger_error("Can't get command stderr contents", E_USER_WARNING);
		return(false);
	}
	$result["stderr"] = $stderr.$contents;
	fclose($PIPE[2]);
	
	proc_close($proc);
	
	return($result);	
}

