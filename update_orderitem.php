<?php

	include_once("functions/function.php");
	session_start(); if(!isset($_SESSION['login'])) session_destroy();

	if(isset($_SESSION['login']))
	{
		$current_customer = get_customers($_SESSION['login']);
		$order = get_order($current_customer[0]['id'], true);

		if(isset($order) and $order != false)
		{
			$current_order = $order[0]['id'];

			// получаем список товаров в неоплаченной покупке
			$order = get_order($current_order, false);
			if(isset($order) and $order != false)
			{
				for($i = 0; $i < count($order); $i++){
					if($order[$i]['amount'] != $_POST['orderitem'.$order[$i]['idequip']]){
						if($_POST['orderitem'.$order[$i]['idequip']] == 0)
							delete_orderitem($order[$i]['idequip'], $order[$i]['idorder']);
						else
							add_orderitem($order[$i]['idorder'], $order[$i]['idequip'], $_POST['orderitem'.$order[$i]['idequip']], false);
					}
				}
			}
		}
	}

	header('location: show_cart.php');

?>