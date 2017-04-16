<?php 


class Dumper{

	private static $_instance = null;	
	private $_db,
			$_tables = array();

	public function __construct()
	{
		try {
			$this->_db = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname='. Config::get('mysql/database').'; charset=utf8', Config::get('mysql/username'),Config::get('mysql/password'));
			$this->_db_hostname = $db_hostname;
			$this->_db_database = $db_database;
			$this->_db_username = $db_username;
			$this->_db_password = $db_password;

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance()
	{
		if(!isset(self::$_instance))														
		{
			self::$_instance = new Dumper();						
		}
		return self::$_instance;
	}

	public function backup(){
		return self::backup_tables($this->_db, $this->_tables);
	}


	private static function backup_tables($DBH, $tables) {

		$DBH->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING );

		//Script Variables
		$compression = true;
		$BACKUP_PATH = Config::get('mysql/database');
		$nowtimename = date('YmdHis');


		//create/open files
		if ($compression) {
			$zp = gzopen($BACKUP_PATH.$nowtimename.'.sql.gz', "w9");
		} else {
			$handle = fopen($BACKUP_PATH.$nowtimename.'.sql','a+');
		}

		//array of all database field types which just take numbers 
		$numtypes=array('tinyint','smallint','mediumint','int','bigint','float','double','decimal','real');

		//get all of the tables
		if(empty($tables)) {

			$pstm1 = $DBH->query('SHOW TABLES');
			
			while ($row = $pstm1->fetch(PDO::FETCH_NUM)) {
				$tables[] = $row[0];
			}

		} else {
			
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}

		//cycle through the table(s)

		foreach($tables as $table) {
			$result = $DBH->query('SELECT * FROM '.$table);
			$num_fields = $result->columnCount();
			$num_rows = $result->rowCount();

			$return="";
			//uncomment below if you want 'DROP TABLE IF EXISTS' displayed
			//$return.= 'DROP TABLE IF EXISTS `'.$table.'`;'; 


			//table structure
			$pstm2 = $DBH->query('SHOW CREATE TABLE '.$table);
			$row2 = $pstm2->fetch(PDO::FETCH_NUM);
			$ifnotexists = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $row2[1]);
			$return.= "\n\n".$ifnotexists.";\n\n";


			if ($compression) {
				gzwrite($zp, $return);
			} else {
				fwrite($handle,$return);
			}
			
			$return = "";

			//insert values
			if ($num_rows){

				$return= 'INSERT INTO `'.$table."` (";
				$pstm3 = $DBH->query('SHOW COLUMNS FROM '.$table);
				$count = 0;
				$counter = 0;
				$type = array();

				while ($rows = $pstm3->fetch(PDO::FETCH_NUM)) {

					if (stripos($rows[1], '(')) {
						$type[$table][] = stristr($rows[1], '(', true);
					} else {
						$type[$table][] = $rows[1];
					}

					$return.= $rows[0];
					$count++;
					
					if ($count < ($pstm3->rowCount())) {
						$return.= ", ";
					}
				}

				$return.= ")".' VALUES';

				if ($compression) {
				gzwrite($zp, $return);
				} else {
				fwrite($handle,$return);
				}
				$return = "";
			}

			while($row = $result->fetch(PDO::FETCH_NUM)) {
				
				$return= "\n\t(";
				for($j=0; $j<$num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
					//$row[$j] = preg_replace("\n","\\n",$row[$j]);


					if (isset($row[$j])) {
					//if number, take away "". else leave as string
						if (in_array($type[$table][$j], $numtypes)) $return.= $row[$j] ; else $return.= '"'.$row[$j].'"' ;
					
					} else {
						$return.= '""';
					}

					if ($j<($num_fields-1)) {
						$return.= ',';
					}
				}



				$counter++;

				if ($counter < ($result->rowCount())) {
					$return.= "),";
				} else {
					$return.= ");";
				}

				if ($compression) {
					gzwrite($zp, $return);
				} else {
					fwrite($handle,$return);
				}
				$return = "";

			}

			$return="\n\n-- ------------------------------------------------ \n\n";
			if ($compression) {
				gzwrite($zp, $return);
			} else {
				fwrite($handle,$return);
			}
			$return = "";
		}



		$error1= $pstm2->errorInfo();
		$error2= $pstm3->errorInfo();
		$error3= $result->errorInfo();
		echo $error1[2];
		echo $error2[2];
		echo $error3[2];

		if ($compression) {
			gzclose($zp);
		} else {
			fclose($handle);
		}

		// $user 			= new User();
		// $users 			= $user->data();
		// $general 		= new General();

		// $filename = $BACKUP_PATH.$nowtimename.'.sql.gz';

		// $general->create('database_backup', array(
		// 	'file_path'	=> '/public/dashboard/database/database_file/'.$filename,
		// 	'file_name'	=> $filename,
		// 	'author'	=> $users->fname . ' ' . $users->lname
		// ));

	}

	public function restore($database_file){
		$restore_file  = "/Macintosh HD/Applications/XAMPP/xamppfiles/htdocs/stratadomain/public/dashboard/database_dump/$database_file";
		$server_name   = $this->_db_hostname;
		$username      = $this->_db_username;
		$password      = $this->_db_password;
		$database_name = $this->_db_database;

		$cmd = "mysql -h {$server_name} -u {$username} -p $password} {$database_name} < $restore_file";

		return exec($cmd);
	} 
}


 ?>