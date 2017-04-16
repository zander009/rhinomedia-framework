<?php

class Redirect
{
	public static function to($locate = null)										
	{
		if($locate):																	
			header('Location:' . $locate);											
			exit(); 
		endif;
	}
}