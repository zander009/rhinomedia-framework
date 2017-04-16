<?php 

class Files
{
	private $_name;
	private $_tmpname;
	private $_size;
	private $_error;

	public static function exist($item){
		return (isset($_FILES[$item])) ? true : false;
	}

	public function __construct($item){
		$files = $_FILES[$item] ?? '';

		if(!empty($files)):
			$this->_name = $files['name'];
			$this->_tmpname = $file['tmp_name'];
			$this->_size = $file['size'];
			$this->_error = $file['error'];
		else:
			throw new Exception("File {$item} is not set", 1);
		endif;

	}

	public function name(){
		return $this->_name;
	}

	public function tmpname(){
		return $this->_tmpname;
	}

	public function size(){
		return $this->_size;
	}

	public function error(){
		return $this->_error;
	}

}