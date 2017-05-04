<?php 
	include("database.php");
	
	function get_data($sql)
	{
		$link = db_connect();
		$db_data = array();

		$result = mysqli_query($link, $sql);

		if(!$result) die(mysqli_error($link));
		$n = mysqli_num_rows($result);

		for($i = 0; $i < $n; $i++)
			$db_data[] = mysqli_fetch_assoc($result);

		return $db_data;
		mysqli_close($link);
	}

	function set_data($sql)
	{
		$link = db_connect();
		mysqli_query($link, $sql);
	}

	function get_categories($id){
		$query = 'select * from categories';
		if($id != 0) $query += ' where id = '.$id;
		$categories = get_data($query);

		if(count($categories) == 0)
			return false;
		else
			return $categories;
	}

	function get_customers($id){
		$query = 'select * from customers';
		if($id != 0) $query += ' where id = '.$id;
		$customers = get_data($query);

		if(count($customers) == 0)
			return false;
		else
			return $customers;
?>