<?php
	include("../database.php");

	function get_categories($id){
		$query = 'select * from categories';
		if($id != 0) $query += ' where id = '.$id;
		$categories = get_data($query);

		if(count($categories) == 0)
			return false;
		else
			return $categories;
	}
?>