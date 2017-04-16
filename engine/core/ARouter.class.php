<?php
/*------------------------------------------------------------
| ROUTER CLASS CONFIGURATION
--------------------------------------------------------------
| DO NOT REMOVE THIS CONFIGURATION UNLESS YOU KNOW WHAT TO DO
| THIS IS DEFAULT STRUCTURE FOR THE CONFIGURATION
| ONLY EDIT ON PART OF THE VALUE
|------------------------------------------------------------*/

class Router{
	
	/*
		GLOBAL VARIABLES
	*/

	private $r = [];
	private $c;
	public  $currentView;
	
	/*
		FUNCTION FOR ROUTING
	*/

	function get($r,callable $c){
		$this->r[$r]=$c;
	}

	/*
		EXECUTING OF ROUTER
	*/

	function exe(){
		$k = $this->r;
		
		$uri = $_SERVER['REQUEST_URI'];
		$getPath = explode(Config::get('base_dir'), $uri);
		$getPathInfo = explode("?", end($getPath))[0];
		
		$e = ($k[$getPathInfo ?? ''] ?? $k['error'])();
		
		if(!empty($e)):
			self::dispatch($e);
		endif;
	}

	private static function dispatch($a){

		/*
			Pasing the params to a new variables
		*/
		
		$platform = $a['platform'];
		$page	  = $a['page'];

		/*
			Initializing constant global variables 
		*/

		self::init($platform, $page);

		/*
			Instanciation of the Controller
		*/

		$controller_name = end($page) . "Controller";
        $action_name = end($page) . "Action";

        try{
        
        	$controller = new $controller_name;
        	$controller->$action_name();
        
        }catch(Exception $e){
        	die($e->getMessage());	
        }
        
	}

	private static function init($platform, $page = array()){
		
		$current_view = '';

		/*
			TRIGGER THE PATH POSITION FOR EACH VIEWS
		*/ 

		if(count($page) > 1):
			$current_view = implode('/', $page);
		else:
			$current_view = end($page);
		endif;

		/*
			REQUESTING
		*/

		DEFINE('PLATFORM', isset($platform) ? $platform : 'home');
		DEFINE('CONTROLLER', isset($current_view) ? $current_view : 'index');

		/*
			CURRENT CONTROLLER AND VIEW DIRECTORY 
		*/
		DEFINE('CURR_CONTROLLER_DIR', CONTROLLER_DIR . PLATFORM . DS);
		DEFINE('CURR_VIEW_DIR', VIEW_DIR . PLATFORM . DS);
		DEFINE('CURR_VIEW', $current_view);
	}

}