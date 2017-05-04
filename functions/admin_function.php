<?php 
	include("../database.php");
	
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

	function get_orders(){
		$query='SELECT orders.id, orders.date, customers.name, orders.status, 
				CONCAT(customers.country, ", ", customers.city, ", ", customers.adress, " (", customers.zip, ")") AS adres,
				SUM(orderitem.amount * equipments.price) AS total,
				SUM(orderitem.amount) AS count
				FROM orders, orderitem, equipments, customers
				WHERE orders.id = orderitem.id 
				AND orderitem.idequipment = equipments.id 
				AND orders.idcustomer = customers.id
				GROUP BY orders.id';
		return get_data($query);
	}

	function get_categories(){
		$query = 'SELECT * FROM categories';
		return get_data($query);
	}

	function get_equipments(){
		$query = 'SELECT equipments.*, categories.name AS category FROM equipments, categories WHERE equipments.idcategory = categories.id';
		return get_data($query);
	}

	function get_customers(){
		$query = 'SELECT * FROM customers';
		return get_data($query);
	}

	function get_admin($login){
		$query = 'SELECT * FROM admin WHERE login = "'.$login.'"';
		$admins = get_data($query);
		if(count($admins) == 0) return false;
		else return $admins;
	}

	function delete_equipments($id){
		$query = 'DELETE FROM equipments WHERE id = '.$id;
		set_data($query);
	}

	function delete_customers($id){
		$query = 'DELETE FROM customers WHERE id = '.$id;
		set_data($query);
	}

	function delete_category($id){
		$query = 'DELETE FROM categories WHERE id = '.$id;
		set_data($query);
	}

	function correct_password($pass, $id){
		$query = 'UPDATE customers SET password = "'.$pass.'" WHERE id = '.$id;
		set_data($query);
	}

	function add_equipment($name, $idcat, $price, $desc, $image){
		$query = 'INSERT INTO equipments VALUES (NULL, "'.$name.'", '.$idcat.', "'.$price.'", "'.$desc.'", "'.$image.'")';
		set_data($query);
	}

	function add_category($name, $image){
		$query = 'INSERT INTO categories VALUES (NULL, "'.$name.'", "'.$image.'")';
		set_data($query);
	}
?>