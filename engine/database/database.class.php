<?php

class DB
{
	private static $_instance = null;														
	private $_query,
			$_error = false ,
			$_results,
			$_count = 0,
			$_table,
			$_fields = "*",
			$_operators = array('=','>','<','>=','<=','<>','LIKE','NOT LIKE','IN','NOT IN'),
			$_joinOperator = array('JOIN','INNER','LEFT','LEFT OUTER','RIGHT','RIGHT OUTER','FULL OUTER'),
			$_logicOperators = array('AND','OR'),
			$_where = array(),
			$_having = array(),
			$_orderBy = "",
			$_groupBy = "",
			$_between = "",
			$_limit = "",
			$_join = array(),
			$_on = array(),
			$_top = "";
	public $_pdo;

	private function __construct()
	{
		$host 	  = Config::get('mysql/host');
		$database = Config::get('mysql/database');
		$username = Config::get('mysql/username');
		$password = Config::get('mysql/password');

		try
		{												
			$this->_pdo = new PDO('mysql:host=' . $host . ';dbname='. $database, $username , $password);
		} 
		catch (PDOException $e)
		{
			die($e->getMessage());
		}
	}

	/*
		SELF INSTANCIATION 
	*/

	public static function getInstance()	
	{
		if(!isset(self::$_instance)):	
		
			self::$_instance = new DB();							
		
		endif;

		return self::$_instance;															
	}

	/*
		EXECUTING OF QUERIES
	*/

	public function query($query, $params = array())						
	{
		$this->_error = false;

		if($this->_query = $this->_pdo->prepare($query)):	
		
			$x = 1;	

			if(!empty($params)):

				foreach ($params as $param):
					
					$this->_query->bindValue($x, $param);
					$x++;									
				
				endforeach;

			endif;
		
		endif;

		if($this->_query->execute()):	

			$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);	
			$this->_count   = $this->_query->rowCount();	
		
		else:
		
			$this->_error = true;	
		
		endif;
		
		return $this;		
	}

	/*
		METHOD FOR PREPARING QUERIES
	*/

	private function action($action, $table, $where = array())	
	{
	
		if(count($where) == 3):
		
			$field 		= $where[0]; 
			$operator 	= $where[1]; 
			$value 		= $where[2]; 

			if(in_array($operator, $this->_operators)):									

				$sql = "$action FROM {$table} WHERE {$field} {$operator} ?";	
				
				return $sql;
				
				if(!$this->query($sql, array($value))->error()):	
				
					return $this;			
				
				endif;

			endif;

		endif;

		return false;
	}

	/*
		DELETE FUNCTION
	*/

	public function delete($table, $where = array())								
	{
		return $this->action("DELETE", $table, $where);					
	}

	/*
		INSERT FUNCTION
	*/

	public function insert($table = '', $fields = array())					
	{
		if(empty($table)):
			throw new Exception("Error Processing Request", 1);
		endif;

		$keys = array_keys($fields);								
		$values = '';
		$x = 1;

		foreach ($fields as $field):
			
			$values .= '?';					
			
			if($x < count($keys)):			
											
				$values .= ', ';									
			
			endif;

			$x++;																			
		endforeach;

		$sql = "INSERT INTO {$table}(`" . implode("`, `", $keys) . "`)VALUES({$values})";	

		if(!$this->query($sql, $fields)->error()):				
		
			return true;																	
		endif;
		
		return false;																		
	}

	/*
		UPDATE FUNCTION
	*/

	public function update($table, $fields = array(), $id, $value) 						
	{

		$x = 1;																	
		$set = '';																		

		foreach ($fields as $name => $val) {								
			$set .= "{$name} = ?"; 														
			if($x < count($fields))													
			{
				$set .= ', '; 													
			}
			$x++;															
		}

		$sql = "UPDATE {$table} SET {$set} WHERE {$id}='{$value}'";			
		
		if(!$this->query($sql, $fields)->error()):							
		
			return true;																	
		endif;

		return false;																		
	}

	/*
		PREPARED STATEMENTS
	*/

	public function call($procedure, $fields = array()){
								
		$this->_error = false;
		$values = '';
		$x = 1;

		if(!empty($fields)):
			
			foreach ($fields as $field):
				
				$values .= '?';					
				
				if($x < count($fields)):			
												
					$values .= ', ';									
				
				endif;

				$x++;																			
			endforeach;

		endif;

		$sql = "CALL {$procedure}({$values})";

		if(!$this->query($sql, $fields)->error()):	
		
			return $this;			
		
		endif;

		return false;

	}

	

	/*
		CUSTOM QUERIES
	*/

	public function customQuery($query){

		if(!empty($query)):

			if(!$this->query($sql)->error()):
				return $this;
			endif;	

		endif;

	}

	/*
		GETTER FOR RESULTS
	*/

	public function results()									
	{
		return $this->_results;
	}
	
	/*
		GETTER FOR THE SPECIFIC RESULTS
	*/

	public function first()				
	{
		return $this->results()[0];
	}

	/*
		GETTER FOR COUNT RESULTS
	*/

	public function count()				
	{	
		return $this->_count;
	}

	/*
		GETTER FOR ERRORS
	*/

	public function error()													
	{
		return $this->_error;
	}

}