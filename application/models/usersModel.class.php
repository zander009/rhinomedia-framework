<?php 

class usersModel extends Model
{
	private $_data = NULL;

	public function find($user = null)														
	{
		if($user):	

			$field = (is_numeric($user)) ? 'get_users_id' : 'get_users_username';			
			$data = parent::callFirst($field, array($user));

			if($data && parent::error()):	
							
				$this->_data = $data;
				return true;
				
			endif;

		endif;

		return false;
	}

	public function data(){
		return $this->_data;
	}

}
