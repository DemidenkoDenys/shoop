<?php
	include_once("functions/function.php");
	session_start(); if(!isset($_SESSION['login'])) session_destroy();

	if(isset($_GET['id']) and isset($_SESSION['login']))
	{
		// получаем данные покупатедя
		$current_customer = get_customers($_SESSION['login']);
		$order = get_order($current_customer[0]['id'], true);

		// если презаказ существует
		if(isset($order) and $order != false)
		{	$current_order = $order[0]['id'];

			// получаем список товаров в неоплаченной покупке
			$order = get_order($current_order, false);

			// если есть хотя бы один товар в предзаказе
			if($order != false){
				$orderitem_exist = false;
				for($i = 0; $i < count($order); $i++){
					if($order[$i]['idequip'] == $_GET['id']){
						add_orderitem($order[$i]['idorder'], $_GET['id'], $order[$i]['amount'] + 1, false);
						$orderitem_exist = true;
					}
				}

				// если товара в предзаказе нет
				if(!$orderitem_exist)
					add_orderitem($current_order, $_GET['id'], 1, true);
			}

			// если товара в предзаказе нет
			else add_orderitem($current_order, $_GET['id'], 1, true);
		}
		else
		{
			add_order($current_customer[0]['id']);
			$order = get_order($current_customer[0]['id'], true);
			add_orderitem($order[0]['id'], $_GET['id'], 1, true);
		}
	}

	header('location: show_cart.php?id='.$_GET['id']);
?>