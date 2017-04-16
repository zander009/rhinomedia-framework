<?php 

class Popup{

	public static function make(){
		echo "<script type='text/javascript' class='popup'> $(function(){ popup(); })</script>";

		self::template();
	}

	public static function activate(){
		return Cookie::put(Config::get('popup/popup_name'), Hash::encryptIt(Server::get('SERVER_ADDR')), Config::get('popup/popup_expiry'));
	}

	public static function destroy(){
		return Cookie::delete(Config::get('popup/popup_name'));
	}

	private static function template(){
		echo '<div class="popup popup-wrapper">
				<div class="overlay" data-dismiss="true"></div>
				<div class="popup-content">
					<div class="wrapper">
						<button class="close" data-dismiss="true">x</button>
						<h4>Subscribe Now!</h4>
						<div class="body">
							'.self::form().'
						</div>
					</div>
				</div>
			</div>';
	}

	public static function form(){
		return '<form action="javascript:void(0)" method="post" class="form-container" id="popup-form">
				<div class="textfield-container for_name">
					<i class="fa fa-user" aria-hidden="true"></i>
					<input type="text" name="name" id="name" data-id="for_name" tabindex="1" value="" placeholder="Name">
				</div>
				<div class="textfield-container for_email">
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
					<input type="email" name="email" id="email" data-id="for_email" tabindex="1" value="" placeholder="Email">
				</div>
			</form>
			<button value="Subscribe" class="btn btn-primary submit" tabindex="3"><span>Subscribe</span><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></button>
			';
	}

}