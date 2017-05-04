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
		if($id != 0) $query .= ' where id = '.$id;
		$categories = get_data($query);

		if(count($categories) == 0) return false;
		else 						return $categories;
	}

	function get_equipments($id, $cat){
		$query = 'select * from equipments ';
		if($id != 0 and $cat) $query .= 'where idcategory = '.$id;
		else if($id != 0 and !$cat) $query .= 'where id = '.$id;
		$equipments = get_data($query);

		if(count($equipments) == 0 or !$equipments) return false;
		else 						return $equipments;
	}

	function get_customers($log){
		$query = 'select * from customers';
		if($log != "0") $query .= ' where login = "'.$log.'"';
		$customers = get_data($query);

		if(count($customers) == 0)  return false;
		else						return $customers;
	}

	function get_order($id, $user){
		// получаем данные о предзаказе
		if($id != 0 and $user)
			$query = '	SELECT  orders.idcustomer, orders.id, 
								customers.name, customers.login
						FROM orders, customers 
							WHERE customers.id = orders.idcustomer 
							AND orders.status = false 
							AND customers.id = '.$id;
		// получаем данные о товарах в предзаказе
		else if($id != 0 and !$user)
			$query = '	SELECT	orderitem.id AS idorder, 
								equipments.id AS idequip, 
								equipments.name, 
								equipments.image, 
								equipments.price, 
								orderitem.amount
						FROM orders, orderitem, equipments 
						WHERE orders.id = '.$id.' 
						AND orders.id = orderitem.id 
						AND orderitem.idequipment = equipments.id 
						GROUP BY orderitem.idequipment';

		$orders = get_data($query);

		if(count($orders) == 0) return false;
		else 					return $orders;
	}

	function get_orderSum($id){
		$query = '	SELECT	SUM(orderitem.amount * equipments.price) AS total,
							SUM(orderitem.amount) AS count
					FROM orders, orderitem, equipments
					WHERE orders.id = '.$id.'
					AND orders.status = 0 
					AND orders.id = orderitem.id 
					AND orderitem.idequipment = equipments.id';

		$sum_order = get_data($query);

		if(count($sum_order) == 0 or is_null($sum_order[0]['total']) == true)
			return false;
		else
			return $sum_order;
	}

	function get_customersdata($field){
		if($field == "country") $field = "country";
		if($field == "city") $field = "city, country";
		if($field == "state") $field = "state, city";
		if($field == "zip") $field = "zip, state";
		$query = 'SELECT city, country, state, zip FROM customers GROUP BY '.$field;
		return get_data($query);
	}

	function add_orderitem($idorder, $idequip, $amount, $add){
		if(isset($idorder) and isset($idequip) and isset($amount)){
			if($idorder != 0 and $idequip != 0 and $amount != 0){
				if($add == false)
					$query = 'UPDATE orderitem SET amount = '.$amount.' WHERE idequipment = '.$idequip.' AND id = '.$idorder;
				if($add == true)
					$query = 'INSERT INTO orderitem (id, idequipment, amount) VALUES ('.$idorder.', '.$idequip.', '.$amount.')';
				set_data($query);
				return true;
			}
			else return false;
		}
		else return false;
	}

	function add_order($idcust){
		$query= 'INSERT INTO orders (id, idcustomer, date, status)
						VALUES (NULL, '.$idcust.', NOW(), 0)';
		set_data($query);
	}

	function delete_orderitem($id, $idorder){
		$query = 'DELETE FROM orderitem WHERE id = '.$idorder.' AND idequipment = '.$id;
		set_data($query);
	}

	function formchar($p){ return nl2br(htmlspecialchars(trim($p), ENT_QUOTES), false); }

?>