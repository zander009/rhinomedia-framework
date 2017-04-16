<?php 

class Helper{
	public static function unset($item){
		unset($item);
	}
	public static function fileExist($path){
		
		if(!empty($path)):
			return file_exists($path);
		endif;

		return false;
	}
}