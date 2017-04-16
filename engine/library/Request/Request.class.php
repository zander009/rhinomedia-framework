<?php 

class Request{

	public static function get($item){
		return $_REQUEST[$item];
	}

	public static function exist($item){
		return (isset($_REQUEST[$item])) ? true : false;
	}
}