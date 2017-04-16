<?php 

class Date
{
	function time($date) {
		$d = strtotime(str_replace("/","-",$date)); 
		return date("l jS \of F Y", $d);
	}

	function getDate($date)
	{
		$dob = strtotime(str_replace("/","-",$date)); 

		if(strtotime('+1 year', $dob) == 31536000):
			return '';
		else:
			$Date = date("M d, Y h:i:s A", strtotime($date));
			return $Date;
		endif;
	}

	function now($hrs = true){
		return $hrs ? date('Y-m-d H:i:s') : date('Y-m-d');
	}

}