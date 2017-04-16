	<?php 


class loginController extends Controller
{

	public function loginAction()
	{
		$this->push->view(CURR_VIEW);	
	}

	public function getTitle(){
		return parent::getTitle();
	}

	public function loadCss(){
		parent::publicLoadStyle();
	}

	public function loadJs(){
		parent::publicLoadScript();
	}

	public function redirectMe(){
		if(parent::isLoggedIn()):
			Redirect::to(Config::get('url'));
		endif;
	}

	public function formExe(){

		$auth 	  = parent::getAuth();
		$remember = (Input::get('remember') === 'on') ? true : false;	

		if(Input::exists()):
			if(Token::check(Input::get('token'))):
				$auth->login(Input::get('username'),Input::get('password'), $remember);

				if($auth->isLoggedIn()):
					if($auth->data()->pos_name === 'admin'):
						Redirect::to(Config::get('url') . 'adminpanel');
					endif;
					Redirect::to(Config::get('url'));
				endif;
			endif;
		endif;
	}

}