<?php

class Config
{
	public static function get($path = NULL)
	{
		if($path):

			$config = $GLOBALS['config'];
			$path = explode("/", $path);

			foreach ($path as $bit):

				$config = isset($config[$bit]) ? $config[$bit] : '';

			endforeach;

			return $config;

		endif;

		return false;
	}
    
}