<?php
	include("function.php");

	function get_categories($id){
		
		$query = 'select * from customers';
		if($id != 0) $query += ' where id = '.$id;
		$categories = get_data($query);

		if(count($categories) == 0)
			return false;
		else
			return $categories;
	}
?>