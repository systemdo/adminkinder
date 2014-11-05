<?php 
namespace app\api;

Class DateFormat{


	static public function formatDateDe($date){
		return date('d-m-Y', strtotime($date));
	}

	static public function formatDateEu($date){
		//echo date('Y-m-d', strtotime(date('d-m-Y')));
		//echo $date;
		//var_dump(date('Y-m-d', strtotime($date)));die();
		return date('Y-m-d', strtotime($date));
	}

	
}
?>