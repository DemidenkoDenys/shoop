<?php

	include_once("functions/function.php");

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();

	// если покупатель авторизован
	if(!isset($_SESSION['login']) or $_POST['nomer'] == '' or !isset($_POST['nomer']) or $_POST['cvv'] == '' or !isset($_POST['cvv']) or $_POST['month'] == '' or !isset($_POST['month']) or $_POST['year'] == '' or !isset($_POST['year']) or $_POST['vladelec'] == '' or !isset($_POST['vladelec']))
		header("location: ".$_SERVER['HTTP_REFERER']);
	else{
		$current_customer = get_customers($_SESSION['login']);	// получаем данные покупатедя
		set_data("UPDATE orders SET status = 1 WHERE idcustomer = ". $current_customer[0]['id']);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Магазин техники Shoop</title>

	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="img/icon.ico" type="image/x-icon">
</head>
<body>
	<div class="header">
		<a href="#" class="logo"></a>

		<div class="cart">
			<p class="name green"><?php echo $current_customer[0]['name'] ?>
				<a class="logout" href="auth.php?logout=false"><img src="img/logout.png" alt="Выйти"></a>
			</p>
			<a href="show_cart.php"><h1>Ваша корзина</h1></a>
		</div>
	</div>

	<div class="carts">
		<p class="thanks green bold">Спасибо что сделали покупку у нас :) Оставайтесь с нами
			<a class="thanks-button button" href="index.php">Вернуться в магазин</a>
		</p>
	</div>

</body>
</html>