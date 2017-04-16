<?php
/*------------------------------------------------------------
| CONFIGURATION FOR PRODUCTION
--------------------------------------------------------------
|DO NOT REMOVE THIS CONFIGURATION UNLESS YOU KNOW WHAT TO DO
|THIS IS DEFAULT STRUCTURE FOR THE CONFIGURATION
|ONLY EDIT ON PART OF THE VALUE
|------------------------------------------------------------*/

return(
	$config = array(

		'mysql' 		=> array(
			'host' 			=> 'localhost',
			'username' 		=> 'root',
			'password' 		=> '',
			'database' 		=> 'rhino_db'
		),
		'remember' 		=> array(
			'cookie_name' 	=> 'hash',
			'cookie_expiry' => 604800
		),
		'session' 		=> array(
			'session_name' 	=> 'user',
			'token_name'	=> 'token',
			'session_log'	=> 'user',
			'popup'			=> 'name'
		),
		'popup'			=> array(
			'popup_name'	=> 'popup',
			'popup_expiry'	=> 2147483647	
		),
		'mailer' 		=>	array(
			'SMTPAuth'		=> true,
			'SMTPDebug' 	=> 2,
			'SMTPSecure' 	=> 'tls',
			'host'			=> 'smtp.gmail.com',
			'username'		=> '',
			'password'		=> '',
			'port'			=> 587,
			'isHTML'		=> true,
			'from'			=> ''
		),
		'mailchimp'	=> array(
			'apikey'		=> '',
			'list_id'	=> array(
				'your-list' => ''
			)
		),
		'url'				=> 'http://rhinomedia.com',
		'base_dir'			=> '/rhinomedia/',
		'timezone'			=> 'Asia/Manila',
		'site_title'		=> 'Rhino Media'
	)
);
