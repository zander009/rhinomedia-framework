<?php 


$router = new Router();


/*------------------------------------------------------------
| PUBLIC ROUTER
--------------------------------------------------------------
|YOU CAN ADD ROUTER HERE
|------------------------------------------------------------*/

$router->get('', function(){
	return array(
		'platform'	=> 'home',
		'page'		=> array('index')
	);
});

$router->get('login', function(){
	return array(
		'platform'	=> 'home',
		'page'		=> array('auth','login')
	);
});

$router->get('logout', function(){
	return array(
		'platform'	=> 'home',
		'page'		=> array('auth','logout')
	);
});



/*------------------------------------------------------------
| ADMIN ROUTER
--------------------------------------------------------------
|YOU CAN ADD ROUTER HERE
|------------------------------------------------------------*/

$router->get('adminpanel', function(){
	return array(
		'platform'	=> 'admin',
		'page'		=> array('index')
	);
});


/*------------------------------------------------------------
| ERROR ROUTERS
--------------------------------------------------------------
|DO NOT REMOVE THIS CONFIGURATION UNLESS YOU KNOW WHAT TO DO
|THIS IS DEFAULT STRUCTURE FOR THE ERROR ROUTERS
|ONLY EDIT ON PART
|------------------------------------------------------------*/

$router->get('error', function(){
	Redirect::to(PERMALINK.'404');
});

$router->get('400', function(){
	include_once(ERRORS_DIR . '400.errors.php');
});

$router->get('401', function(){
	include_once(ERRORS_DIR . '401.errors.php');
});

$router->get('403', function(){
	include_once(ERRORS_DIR . '403.errors.php');
});

$router->get('404', function(){
	include_once(ERRORS_DIR . '404.errors.php');
});

$router->get('414', function(){
	include_once(ERRORS_DIR . '414.errors.php');
});

$router->get('500', function(){
	include_once(ERRORS_DIR . '500.errors.php');
});

$router->get('502', function(){
	include_once(ERRORS_DIR . '502.errors.php');
});

$router->get('503', function(){
	include_once(ERRORS_DIR . '503.errors.php');
});

/*------------------------------------------------------------
| EXECUTE ALL THE SHORTCODE ROUTER
|------------------------------------------------------------*/

$router->exe();