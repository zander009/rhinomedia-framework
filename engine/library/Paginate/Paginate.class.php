<?php 


class Paginate 
{

	private $_limit,
			$_perPage,
			$_lastPage,
			$_page;

	public function __construct()												
	{
		try {
			$this->_db = DB::getInstance();	
		} catch (Exception $e) {
			die($e->getMessage());
		}
							
	}

	public function getCount($query = '')
	{
		if(!empty($query)):
			$field = $this->_db->customQuery($query);
		endif;

		if($field->count() > 0):
			return $field->count();
		endif;

		return 0;
	}

	public function pull($table, $getPage, $where = '',$numPerPage)
	{
		$count = self::getCount($table,$where);

		if(isset($getPage)):
			$page = preg_replace("#[^0-9]#","",$getPage);
		else:
			$page = 1;
		endif;

		$perPage = $numPerPage;
		$lastPage = ceil($count / $perPage);
		
		if($getPage < 1):
			$page = 1;
		elseif($getPage > $lastPage):
			$page = $lastPage;
		endif;

		$limit = ($page * $perPage ) - $perPage;

		$this->_limit = $limit;
		$this->_perPage = $perPage;
		$this->_page = $page;
		$this->_lastPage = $lastPage;

	}
	public function getAll($table, $fields = '*', $where = '', $id, $order){

		$query = "SELECT $fields FROM $table $where ORDER BY $id $order LIMIT $this->_limit,$this->_perPage";
		$field = $this->_db->customQuery($query);

		if($field->count() > 0):
			return $field->results();
		endif;

		return false;
	}
	
	public function getLimit()
	{
		return $this->_limit;
	}
	public function getPerPage()
	{
		return $this->_perPage;
	}
	public function getPage()
	{
		return $this->_page;
	}
	
	public function getLastPage()
	{
		return $this->_lastPage;
	}
}