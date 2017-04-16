<?php 

namespace engine\core;

class Http{
	public static function init($path){
		// DIRECTORY SEPARATOR " / "
		DEFINE('DS', DIRECTORY_SEPARATOR);
		// DIRECTORY PATH
		DEFINE('ROOT_DIR', $_SERVER['DOCUMENT_ROOT'] . DS . $path . DS);

		$GLOBALS['config'] = INCLUDE(ROOT_DIR . "application/config/development.php");

		spl_autoload_register(function($class){
			require_once(ROOT_DIR . "engine/library/{$class}/{$class}.class.php");
		});

		require_once(ROOT_DIR . 'engine/database/database.class.php');
	}
}