<?php
	include_once("functions/function.php");
	session_start();

	if(isset($_POST)){
		if(	isset($_POST['fio']) and $_POST['fio'] != '' and
			isset($_POST['strana']) and $_POST['strana'] != '' and
			isset($_POST['gorod']) and $_POST['gorod'] != '' and
			isset($_POST['oblast']) and $_POST['oblast'] != '' and
			isset($_POST['zip']) and $_POST['zip'] != '' and
			isset($_POST['adres']) and $_POST['adres'] != '' and
			isset($_POST['login']) and $_POST['login'] != '' and 
			isset($_POST['password']) and $_POST['password'] != '')
		{
			$registerCustomer = get_data("SELECT login FROM customers WHERE login = '".$_POST['login']."'");
			if(count($registerCustomer) > 0 or $registerCustomer != false)
				echo 'такой уже есть';
			else{
				set_data('INSERT INTO customers VALUES(NULL, "'.$_POST['fio'].'", "'.$_POST['adres'].'", "'.$_POST['gorod'].'", "'.$_POST['oblast'].'", "'.$_POST['login'].'", "'.$_POST['password'].'", "'.$_POST['zip'].'", "'.$_POST['strana'].'")');
				$_SESSION['login'] = $_POST['login'];
			}
		}

		header("location: show_cart.php");
	}

?>