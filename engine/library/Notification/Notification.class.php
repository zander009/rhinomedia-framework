<?php 


Class Notification 
{
	public static function flash($state, $message){

		$notif = '';

		if(Session::exist($state)):

			$notif .= "<script type='text/javascript' class='notif'> $(function(){ notification('{$state}'); })</script>";

			$notif .= "<div class='notification notif'>
					<div class='notifier-wrapper'>
						<button class='close' data-dismiss='false'>x</button>
						<h5>Message!</h5>
						<pre>{$message}</pre>
					</div>
				 </div>";

			Session::delete($state);
		endif;

		echo $notif;					 
	}

}