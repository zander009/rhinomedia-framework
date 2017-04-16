<?php 

class Server
{
	public static function get($item){
		try {
			return $_SERVER[$item];
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}