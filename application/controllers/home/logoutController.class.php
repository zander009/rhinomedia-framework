<?php 


class logoutController extends Controller
{
	public function logoutAction()
	{
		$this->push->view(CURR_VIEW);	
	}

	public function getTitle(){
		return parent::getTitle();
	}

	public function redirectMe(){
		if(!parent::isLoggedIn()):
			Redirect::to(Config::get('url'));
		endif;
	}

	public function logout(){

		parent::getAuth()->logout();
		$user = parent::data()->username;

		Session::flash("success", "Goobye! <span class='capitalize'>{$user}</span>");
		Redirect::to(Config::get('url'));
	}

}