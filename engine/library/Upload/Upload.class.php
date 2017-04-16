<?php 

Class Upload
{
	private static $_instance = null;
	private $_passed = false,
			$_errors = array(),
			$_type 	 = array(),
			$_file_tmp = '',
			$_file_path = '',
			$_file_ext = '',
			$_path = '';

	public function __construct($type = array()){
		self::allowed($type);
	}

	public static function getInstance($type = array())	
	{
		if(!isset(self::$_instance)):	
		
			self::$_instance = new Upload($type);							
		endif;

		return self::$_instance;															
	}

	private function allowed($type =  array()){
		$this->_type = $type;
	}

	public function getFileContent($item, $new_filename = '', $new_filesize = 20971520)
	{

		if(Files::exists($item)):
		  	
		  	$file = new Files($item);
		 
		    // File properties
		  	$file_name 	= $file->name();
		  	$file_tmp 	= $file->tmpname();
		  	$file_size 	= $file->size();
		  	$file_error = $file->error();

		  	// File extension
		  	$file_ext = explode(".", $file_name);
		  	$file_ext = strtolower(end($file_ext));

		  	$allow = $this->_type;
		  
		  	if(in_array($file_ext, $allow)):
		      	
		      	if($file_error === 0):

		          	if($file_size <= $new_filesize):
		          		
		          		if(empty($new_filename)):
		          			$file_newname = uniqid("",true) . '.' . $file_ext;
		          		else:
		          			$file_newname = $new_filename . '.' . $file_ext;
		          		endif;
		              	
		              	$file_destination = 'public/uploads/'. $this->_path . DS . $file_newname;

		              	$this->_passed = true;
		              	$this->_file_tmp = $file_tmp;
		              	$this->_file_path = $file_destination;
		              	$this->_file_ext = $file_ext;
		              	
		          	else:

		          		$this->addError("The size of the file is not allowed. The file must be maximum size of {$new_filesize} bytes");
		          	
		          	endif;
		      	else:

		      		$this->addError('There is a problem in your file.');
		      	
		      	endif;

		  	else:
		  		
		  		if($file_ext == ''):
		  			$this->addError('File is required.');
				else:
					$this->addError('The file [ .'.$file_ext.' ] is not allowed.');
				endif;

		  	endif;

		endif;
	}

	public function isUploaded()
	{
		return move_uploaded_file($this->_file_tmp, $this->_file_path) ? true : false;
	}
	public function location($path){
		$this->_path = $path;
		return $this;
	}

	public function filepath(){
		return $this->_file_path;
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