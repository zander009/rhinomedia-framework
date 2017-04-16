<?php

class Input
{
	public static function exists($method = "post")								
	{
		switch ($method): 														
			case 'post': return (!empty($_POST)) ? true : false; break;
			case 'get':  return (!empty($_GET)) ? true : false; break;
			default: return false; break;
		endswitch;
	}

	public static function get($item)											
	{
		if(isset($_POST[$item])):												
			return $_POST[$item];												
		elseif(isset($_GET[$item])):																						
			return $_GET[$item];												
		endif;
		
		return '';																
	}

	public static function reset($item)
	{
		if(isset($_POST[$item])):												
			return $_POST[$item] = '';												
		elseif(isset($_GET[$item])):																					
			return $_GET[$item] = '';												
		endif;
		
		return '';
	}
}