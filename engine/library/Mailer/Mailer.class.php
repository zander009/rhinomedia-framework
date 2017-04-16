<?php 

class Mailer{

	private $_mailer;
	private static $_instance = null;
			

	private function __construct($mailer)
	{
		try
		{						
			$this->_mailer = $mailer;

			$mailer->isSMTP();
			$mailer->Host = Config::get('mailer/host');
			$mailer->SMTPAuth = Config::get('mailer/SMTPAuth');
			$mailer->SMTPSecure = Config::get('mailer/SMTPSecure');
			$mailer->Port = Config::get('mailer/port');
			$mailer->Username = Config::get('mailer/username');
			$mailer->Password = Config::get('mailer/password');
			$mailer->From = Config::get('mailer/username');
			$mailer->isHTML(Config::get('mailer/isHTML'));
			$mailer->FromName = Config::get('mailer/from');
			
		} 
		catch (Exception $e)
		{
			die($e->getMessage());															
		}
	}

	public static function getInstance($mail)													
	{
		if(!isset(self::$_instance)):														
			self::$_instance = new Mailer($mail);													
		endif;
		
		return self::$_instance;															
	}

	public function addReplyTo($email, $reply){
		return $this->_mailer->addReplyTo($email, $reply);
	}

	public function addAddress($email, $name){
		return $this->_mailer->addAddress($email, $name);
	}

	public function subject($subject){
		return $this->_mailer->Subject = $subject;
	}

	public function body($content){
		return $this->_mailer->Body = $content;
	}

	public function altBody($alt){
		return $this->_mailer->AltBody = $alt;
	}

	public function send(){
		return $this->_mailer->send();
	}

}
