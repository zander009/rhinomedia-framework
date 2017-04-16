<?php 

class Model
{
	public $_db;
	private $_error = FALSE;

	public function callFirst($procedure, $params){
		DB::getInstance()->call($procedure, $params);

		if(DB::getInstance()->count() > 0){
			$this->_error = TRUE;
			return DB::getInstance()->first();
		}

		$this->_error = FALSE;
		return FALSE;
	}

	public function call($procedure, $params){
		DB::getInstance()->call($procedure, $params);

		if(DB::getInstance()->count() > 0){
			$this->_error = TRUE;

			return DB::getInstance()->results();
		}

		return FALSE;
	}

	public function error(){
		return $this->_error;
	}
}