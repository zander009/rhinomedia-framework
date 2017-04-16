<?php 

	/*-------------------------------------
					HEADER
	---------------------------------------*/	
	define('TITLE', 'Admin Panel');
	require_once('part/header.php'); 
	define('SUB_TITLE', 'admin');	

	$controller->redirectMe();
	$controller->notification();

	echo <<<HTML
		<h1>Welcome! <span class="capitalize">$data->pos_name</span></h1>
		<a href="logout" class="btn btn-primary">Logout</a>
HTML;

	/*-------------------------------------
					FOOTER
	---------------------------------------*/	
	require_once(VIEW_DIR . 'admin/part/footer.php'); 

?>
