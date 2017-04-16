<?php 

class Controller
{
	protected $push;
	protected $router;
	protected $_auth;
	protected $_authModel;
	protected $_userModel;

	public function __construct(){
		$this->push = new Loader();
		$this->router = new Router();
		$this->_authModel = new authModel();
		$this->_userModel = new usersModel();

		/*
			Checking for Cookie if the cookie exist it automatically signed in
		*/

		if(Cookie::exist(Config::get('remember/cookie_name')) && !Session::exist(Config::get('session/session_name')))
		{
			$cookie_hash = Cookie::get(Config::get('remember/cookie_name'));	
			$user = DB::getInstance()->call('get_session', array($cookie_hash));

			if($user->count())
			{
				$this->_authModel = new authModel($user->first()->user_id);
			}
		}

		/*
			Blocking IP address
		*/

		self::blockedIP();

	}

	public function getTitle(){
		// getting the title of each page
		return !empty(TITLE) ? TITLE . ' | ' . PROJECT_TITLE : PROJECT_TITLE;
	}

	/*
		Public Loading for fonts
	*/

	protected function loadFonts(){
		$this->push->publicLoaderFonts('Poppins:700');
		$this->push->publicLoaderFonts('Open+Sans:400,700');

		return $this;		
	}

	/*
		Public Loading for stylesheet
	*/

	protected function publicLoadStyle(){
		self::loadFonts();
		$this->push->publicPush('fonts','font-awesome/css');
		$this->push->publicPush('css','default-template');
		$this->push->publicPush('js','jquery');
	}

	/*
		Public Loading for scripts
	*/

	protected function publicLoadScript(){
		
		$this->push->publicPush('js','default-js');
		$this->push->publicPush('js','jquery/validation');
		$this->push->publicPush('js','jquery/notification');
		$this->push->publicPush('js','jquery/form');
		$this->push->publicPush('js','jquery/popup');
		$this->push->publicPush('js','jquery/mobile-responsive');
	}

	public function isLoggedIn(){
		return self::getAuth()->isLoggedIn();
	}

	public function data(){
		return self::getAuth()->data();
	}

	/*
		Getter for Authentication User
	*/

	protected function getAuth(){
		return $this->_authModel;	
	}

	/*
		Notification for Welcome Command
	*/

	public function notification(){
		
		$auth = self::getAuth();
		$isLoggedIn =  self::isLoggedIn();
		$data = self::data();

		if($isLoggedIn):
			Notification::flash("success","Welcome! <span class='capitalize'>{$data->username}</span>");
		else:
			if(Session::exist("success")):
				Notification::flash("success", Session::get("success"));
			endif;
		endif;
	}

	/*
		Method for Lead Generation Email
	*/

	public function popup(){

		$name = Input::get('name');
		$email = Input::get('email');
		$ip = Server::get('REMOTE_ADDR');
		$ipLocate = IPlocator::locate('122.3.159.143');
		$timezone = $ipLocate->getTimezone();
		$cc = $ipLocate->getCountryCode();
		$region = $ipLocate->getRegionName();

		if(!empty($name) && !empty($email)){
		 	
		 	DB::getInstance()->call('set_users_subscription',array($name, $email, $ip, $timezone, $cc, $region));

		 	// MChimp::getInstance()->subscribe(Config::get('mailchimp/list_id/newsletter'), $email, $name);

		 	Session::put('success', 'Thank you for subscribing!');

			Popup::activate();
		}

		if(!Cookie::exist(Config::get('popup/popup_name'))):
			Popup::make();
		endif;
		
	}

	public function blockedIP(){
		
		$ip = Server::get('REMOTE_ADDR');
		$data = DB::getInstance()->call('get_ip_blocked', array($ip));
		$count = $data->count();

		if($count){
			die("Your ip address ($ip) has been blocked due to malicious act.");
		}

	}

}


