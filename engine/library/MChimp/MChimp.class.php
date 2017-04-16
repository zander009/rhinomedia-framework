<?php 


class MChimp{

	private static $_instance = NULL;
	private $_apikey = NULL;
	private $mc = NULL;
	public $lists = NULL;
	private $details = array();
	private $members = array();

	private function __construct(){

		$this->_apikey = Config::get('mailchimp/apikey');
		$this->mc = new Mailchimp($this->_apikey);

		$this->lists = new Mailchimp_Lists($this->mc);

	}

	public static function getInstance(){

		if(!isset(self::$_instance)):	
			self::$_instance = new MChimp();	
		endif;

		return self::$_instance;	
	}

	public function subscribe($listkey = '', $email = '', $fname = '', $lname = ''){

		$email = array(
			'email' => htmlentities($email)
		);

		$merge_var = array(
			'FNAME' => $fname,
			'LNAME'	=> $lname
		);

		$subscriber = $this->lists->subscribe($listkey, $email, $merge_var);

		if(!empty($subscriber['leid'])):
			Session::put('success','notif');
			Notification::flash('success','Thanks for Subsbribing! :)');
		else:
			Session::put('errors','notif');
			Notification::flash('errors','We ecounter an error when subscribing!');
		endif;
	}

	public function unsubscribe($listkey, $email){

		$unsubscribe = $this->lists->unsubscribe($listkey, $email, false);

		return $unsubscribe;
	}

	public function members($listkey){
		
		$mc = $this->lists->members($listkey);
		
		$euid = '';
		$leid = '';
		$fname = ''; 
		$lname = ''; 
		$email = ''; 
		$latitude = ''; 
		$longitude = ''; 
		$timezone = ''; 
		$cc = ''; 
		$region = ''; 
		$status = ''; 
		$ip = ''; 
		$rating = '';
		$vip = '';
		$timestamp_signup = ''; 
		$timestamp_opt = '';

		foreach ($mc as $key => $data):

			if($key === 'data'):

				foreach ($data as $k => $value):

					foreach ($value['merges'] as $merges => $r):
						
						switch ($merges):

							case 'FNAME':
								$fname = $r;
								break;

							case 'LNAME':
								$lname = $r;
								break;
							
							default:
								$email = $r;
								break;
						endswitch;

					endforeach;

					foreach ($value['geo'] as $geo => $e):
						
						switch ($geo):

							case 'latitude':
								$latitude = $e;
								break;
							case 'longitude':
								$longitude = $e;
								break;
							case 'timezone':
								$timezone = $e;
								break;
							case 'cc':
								$cc = $e;
								break;
							case 'region':
								$region = $e;
								break;

						endswitch;		

					endforeach;
					
					$euid = $value['euid'];
					$leid = $value['leid'];
					$status = $value['status'];
					$rating = $value['member_rating'];
					$vip = $value['is_gmonkey'];
					$ip = $value['ip_signup'];
					$timestamp_signup = $value['timestamp_signup'];
					$timestamp_opt = $value['timestamp_opt'];

					$this->details[$k] = array(
						'euid'		=>	$euid,
						'leid'		=>	$leid,
						'fname'		=>	$fname, 
						'lname'		=>	$lname, 
						'email'		=>	$email, 
						'lat'		=>	$latitude,
						'long'		=>	$longitude, 
						'timezone'	=>	$timezone, 
						'cc'		=>	$cc, 
						'region'	=>	$region, 
						'status'	=>	$status, 
						'rating'	=>	$rating, 
						'vip'		=>	$vip, 
						'ip'		=>	$ip, 
						'created'	=>	$timestamp_signup, 
						'updated'	=>	$timestamp_opt
					);

				endforeach;

			endif;

		endforeach;

		return $this->details;
	}

	
}
