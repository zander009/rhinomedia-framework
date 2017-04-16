<?php
error_reporting(0);

class Validate 
{
	private $_passed = false, 													
			$_errors = array(),
			$_db = null;

	public function __construct()												
	{
		$this->_db = DB::getInstance();											
	}

	public function check($source, $items = array())							
	{
		foreach ($items as $item => $rules): 	

			foreach ($rules as $rule => $rule_value):		

				$value = $source[$item]; 										
				$item = escape($item); 											
				if($rule === 'required' && empty($value)):						
					$this->addError("{$item} is required.");					
				else:
					switch ($rule):												
			
						case 'contact':												
							if(strlen($value) < $rule_value):					
								$this->addError("{$item} must be a {$rule_value} digit number.");
							endif;
						break;
						case 'min':												
							if(strlen($value) < $rule_value):
								$this->addError("{$item} must be minimum required of {$rule_value} characters.");
							endif;
						break;
						case 'max':
							if(strlen($value) > $rule_value):					
								$this->addError("{$item} must be maximum required of {$rule_value} characters.");
							endif;
						break;
						case 'matches':
							if($value != $source[$rule_value]):	
								$this->addError("{$rule_value} must match {$item}.");
							endif;
						break;
						case 'unique':
							$check = $this->_db->table($rule_value)
												->where(array($item,"=",$value))
      											->get();
							if($check->count()):									
								$this->addError("{$item} already exist.");		
							endif;
						break;
						case 'email_only':
							if($rule_value):
								$email = filter_var($source[$item], FILTER_SANITIZE_EMAIL); 

								if(filter_var($email, FILTER_VALIDATE_EMAIL) === false):
									if(!empty($email)):
										$this->addError("{$email} is not a valid email address");
									endif;
								endif;
						    endif;
					    break;
					endswitch;
				endif;
			endforeach;
		endforeach;

		if(empty($this->_errors)):												
			$this->_passed = true;												
		endif;

		return $this;															
	}

	public function passed()
	{
		return $this->_passed;													
	}

	public function addError($error)
	{
		return $this->_errors[] = $error;										
	}

	public function errors()
	{
		return $this->_errors;													
	}
}