<?php 

class authModel extends usersModel
{
	private $_session_name;
	public $_isLoggedIn = FALSE;

	public function __construct($user = ''){

		if(!empty($user)):

			if(parent::find($user)):														
				$this->_isLoggedIn = TRUE;												
			endif;
		
		else:
			
			if(Session::exist(Config::get('session/session_name'))):					
			
				$user = Session::get(Config::get('session/session_name'));					
				
				if(parent::find($user)):														
					$this->_isLoggedIn = TRUE;												
				endif;

			endif;
		
		endif;
	}

	public function login($username = '', $password = '', $remember = FALSE){

		/*
			Checking for the user
		*/

		if(!empty($username) && !empty($password)):

			$user = parent::find($username);

			if($user):

				$passHash = Hash::make($password, parent::data()->password_salt);
				$password = Hash::encryptIt($passHash);

				if($password == parent::data()->password):

					self::rememberMe($remember);
					
					Session::put(Config::get('session/session_name'), parent::data()->user_id);
					Session::put('success','notif');

					return $this->_isLoggedIn = TRUE;
				
				else:

					Session::put('errors','notif');
					Notification::flash('errors','Invalid Password!');

					return $this->_isLoggedIn = FALSE;
				
				endif;

			endif;
			
			Session::put('errors','notif');
			Notification::flash('errors','Seems that your account is not on the list!');

			return $this->_isLoggedIn = FALSE;
			
		endif;

		return $this->_isLoggedIn = FALSE;
	}	

	private function rememberMe($remember){
		
		if($remember):
			
			$session_hash = Hash::unique();
			$user = parent::data()->user_id;
			
			parent::call('set_users_session', array($user, $session_hash));

			Cookie::put(Config::get('remember/cookie_name'), $session_hash, Config::get('remember/cookie_expiry'));	
		endif;
	
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}

	public function logout(){

		if(Cookie::exist(Config::get('remember/cookie_name'))):

			$cookie_hash = Cookie::get(Config::get('remember/cookie_name'));

			parent::call('remove_users_session', array($cookie_hash));

			Cookie::delete(Config::get('remember/cookie_name'));

		endif;

		Session::delete(Config::get('session/session_name'));

	}
}