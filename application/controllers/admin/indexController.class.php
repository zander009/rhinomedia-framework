<?php 


class indexController extends Controller
{
	public function indexAction()
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
			if(parent::data()->pos_name != 'admin'):
				Redirect::to(Config::get('url'));
			endif;
		else:
			Redirect::to(Config::get('url'));
		endif;
	}
}