<?php 

	/*-------------------------------------
					HEADER
	---------------------------------------*/
	define('TITLE', 'Login');	
	require_once(VIEW_DIR . 'home/part/header.php');

	$controller->redirectMe();
	$controller->formExe();
	
?>
<pre><strong>Use this credentials</strong></pre>
<pre><strong>username:</strong> admin</pre>
<pre><strong>password:</strong> password</pre>

<div class="container login">
	<div class="wrapper">
		<h1>Login</h1>
		<form action="" method="post" class="form-container" id="login-form">
			<div class="textfield-container for_username">
				<i class="fa fa-user" aria-hidden="true"></i>
				<input type="text" name="username" id="username" data-id="for_username" tabindex="1" value="<?php echo Input::get('username'); ?>" placeholder="Username">
			</div>
			<div class="textfield-container for_password">
				<i class="fa fa-lock" aria-hidden="true"></i>
				<input type="password" name="password" id="password" data-id="for_password" tabindex="2" placeholder="Password">
			</div>
			<div class="field-container for_remember">
				<label for="remember">
				<input type="checkbox" name="remember" id="remember" data-id="for_remember" tabindex="3">
				<span class="label-text">
					<i></i>
					Remember Me
				</span>
				</label>
			</div>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<button class="btn btn-primary" tabindex="4">Submit</button>
		</form>
	</div>
</div>

<?php

	/*-------------------------------------
					FOOTER
	---------------------------------------*/	
	require_once(VIEW_DIR . 'home/part/footer.php'); 

?>
