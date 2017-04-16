<?php 
	
	HEADER ("Content-type: text/json");

	require_once('../../engine/core/AHttp.class.php');

	use \engine\core as http;

	\http\Http::init('directories');

	$data = 'rhinomedia';

	echo json_encode($data);