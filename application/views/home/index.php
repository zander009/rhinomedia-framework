<?php 

	/*-------------------------------------
					HEADER
	---------------------------------------*/
	define('TITLE', 'Home');
	define('SUB_TITLE', date('h:i:s a'));		
	require_once(VIEW_DIR . 'home/part/header.php');
	
	$controller->notification();
	// $controller->popup();

?>
	
	<section class="welcome-wrapper">
		<div class="container">
			<h1>Welcome! <span class="capitalize"><? echo ($isLoggedIn) ?  $data->fname . " " . $data->lname : ''; ?></span></h1>
			<?php if($isLoggedIn): ?>
				<a href="logout" class="btn btn-primary">Logout</a>
			<?php else: ?>
				<a href="login" class="btn btn-primary">Login</a>
			<?php endif; ?>
		</div>
	</section>
	
	

<?php	
	/*-------------------------------------
					FOOTER
	---------------------------------------*/	
	require_once(VIEW_DIR . 'home/part/footer.php'); 

?>
