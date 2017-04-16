<?php
/*------------------------------------------------------------
| APPLICATION CONFIGURATION
--------------------------------------------------------------
| DO NOT REMOVE THIS CONFIGURATION UNLESS YOU KNOW WHAT TO DO
| THIS IS DEFAULT STRUCTURE FOR THE CONFIGURATION
| ONLY EDIT ON PART OF THE VALUE
|------------------------------------------------------------*/

class App{

	public function run(){
		self::init();
		self::autoload();
		self::route();
	}

	public static function init(){
		/* Initialization */

		// DIRECTORY SEPARATOR " / "
		DEFINE('DS', DIRECTORY_SEPARATOR);
		// DIRECTORY PATH
		DEFINE('DIR', getcwd() . DS);
		// VENDOR DIRECTORY
		DEFINE('VENDOR_DIR', DIR . 'vendor' . DS);

		// APPLICATION DIRECTORY
		DEFINE('APPLICATION_DIR', DIR . 'application' . DS);
		// APPLICATION > CONFIG DIRECTORY
		DEFINE('CONFIG_DIR', APPLICATION_DIR . 'config' . DS);
		// APPLICATION > CONTROLLERS DIRECTORY
		DEFINE('CONTROLLER_DIR', APPLICATION_DIR . 'controllers' . DS);
		// APPLICATION > MODELS DIRECTORY
		DEFINE('MODEL_DIR', APPLICATION_DIR . 'models' . DS);
		// APPLICATION > VIEWS DIRECTORY
		DEFINE('VIEW_DIR', APPLICATION_DIR . 'views' . DS);
		// APPLICATION > ROUTER DIRECTORY
		DEFINE('ROUTER_DIR', APPLICATION_DIR . 'router' . DS);

		// FRAMEWORK DIRECTORY
		DEFINE('FRAMEWORK_DIR', DIR . 'engine' . DS);
		// FRAMEWORK > CORE DIRECTORY
		DEFINE('CORE_DIR', FRAMEWORK_DIR . 'core' . DS);
		// FRAMEWORK > DATABASE DIRECTORY
		DEFINE('DATABASE_DIR', FRAMEWORK_DIR . 'database' . DS);
		// FRAMEWORK > LIBRARY DIRECTORY
		DEFINE('LIBRARY_DIR', FRAMEWORK_DIR . 'library' . DS);


		// PUBLIC DIRECTORY
		DEFINE('PUBLIC_DIR', DIR . 'public' . DS);
		// PUBLIC > CSS DIRECTORY
		DEFINE('CSS_DIR', PUBLIC_DIR . 'css' . DS);
		// PUBLIC > FONTS DIRECTORY
		DEFINE('FONTS_DIR', PUBLIC_DIR . 'fonts' . DS);
		// PUBLIC > IMAGES DIRECTORY
		DEFINE('IMAGES_DIR', PUBLIC_DIR . 'images' . DS);
		// PUBLIC > JS DIRECTORY
		DEFINE('JS_DIR', PUBLIC_DIR . 'js' . DS);
		// PUBLIC > UPLOADS DIRECTORY
		DEFINE('UPLOADS_DIR', PUBLIC_DIR . 'uploads' . DS);

		// ERRORS DIRECTORY
		DEFINE('ERRORS_DIR', DIR . 'errors' . DS);

		// CONFIGURATION LOCATED @ application/config/{$type}.php development
		$GLOBALS['config'] = INCLUDE( CONFIG_DIR . self::config(DIR) . '.php');

		// BASE URL YOU CAN CHANGE THIS LOCATED @ application/config/{$type}.php
		DEFINE('PERMALINK', $GLOBALS['config']['url']);
		DEFINE('PROJECT_TITLE', $GLOBALS['config']['site_title']);

		require_once(VENDOR_DIR . 'autoload.php');
		require_once(DATABASE_DIR . 'database.class.php');
		require_once(FRAMEWORK_DIR . 'core/AController.class.php');
		require_once(FRAMEWORK_DIR . 'core/ALoader.class.php');
		require_once(FRAMEWORK_DIR . 'core/AModel.class.php');
		require_once(FRAMEWORK_DIR . 'core/ARouter.class.php');

		// error_reporting(0);
		session_start();
		ob_start();

		// TIMEZONE
		date_default_timezone_set($GLOBALS['config']['timezone']);
	}

	/*
		CONFIGURATIONS @developemet or @production
	*/

	private static function config($path){
		/* CONFIGURATION STATUS */

		$config = file_get_contents($path . 'config.ini');
		return $config;

	}

	/*
		REQUIRE FOR ROUTING 
	*/

	private function route(){
		require_once(ROUTER_DIR . 'router.php');
	}

	/*
		AUTO LOADING FOR CLASSES
	*/

	private static function autoload(){
		/* AUTOLOAD ALL THE CLASSES */

		spl_autoload_register(function($class){
			self::load($class);
		});

	}

	private static function load($classname){
        /* REQUIRING CLASSES */

        $path = '';

        if (substr($classname, -10) == "Controller"){

        	$path = CURR_CONTROLLER_DIR . "$classname.class.php";

        } elseif (substr($classname, -5) == "Model"){
     
        	$path = MODEL_DIR . "$classname.class.php";

        } else{

        	$path =  LIBRARY_DIR . $classname . DS ."$classname.class.php";
        }
        
        if(file_exists($path)):
        	require_once $path;
    	endif;
    }

}
