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

}