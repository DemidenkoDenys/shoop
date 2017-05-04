<?php 
	include_once("functions/function.php");

	// ini_set('display_errors', 1);
	// error_reporting(E_ALL);

	session_start();
	// если покупатель авторизовался
	if(!isset($_SESSION['login'])) session_destroy();
	else{
		$current_customer = get_customers($_SESSION['login']); // получаем данные покупатедя
		$order = get_order($current_customer[0]['id'], true);

		if(isset($order) and $order != false)
			$sumOrder = get_orderSum($order[0]['id']);
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

			<?php
				if(isset($current_customer) and $current_customer != false){
					echo   '<p class="name green">'.$current_customer[0]['name'].'
							<a class="logout" href="auth.php?logout=true"><img src="img/logout.png" alt="Выйти"></a>
							</p>
							<a class="cart-button button" href="show_cart.php">В корзину<img src="img/cart.png" alt="В корзину"></a>';

					if(isset($sumOrder) and $sumOrder != false)
						echo '<p class="total green">Выбрано <span>'.$sumOrder[0]['count'].'</span> товаров на сумму <span>'.$sumOrder[0]['total'].' грн</span></p>';
					else
						echo '<p class="total green">Нет выбранных товаров</p>';
				}
				else{
					echo '<form action="auth.php" method="post" autocomplete="off"><input type="text" name="login" placeholder="Введите логин" required>';
					echo '<input type="password" name="password" placeholder="Введите пароль" required>';
					echo '<input class="cart-button button enter" type="submit" value="Войти"></form>';
					echo '<a class="cart-button button register" href="checkout.php">Регистрация</a>';
				}
			?>

		</div>
	</div>

	<div class="container">
		<p class="green">Добро пожаловать в магазин стеклянной посуды Shoop...</p>

		<?php 
			$categories = get_categories(0);

			if($categories != false)
			{
				echo '<p>Выберите категорию...</p>';

				echo '<ul>';
				for ($i = 0; $i < count($categories); $i++)
					echo '<li><a href="show_cat.php?id='.$categories[$i]['id'].'"><img src="/img/categories/'.$categories[$i]['image'].'" alt="'.$categories[$i]['name'].'"><p>'.$categories[$i]['name'].'</p></a></li>';
				echo '</ul>';
			}
			else
				echo '<p>Нет ни одной категории!</p>';
		?>
		</ul>
	</div>
</body>
</html>

<?php

	if(isset($_GET['er'])){
		$site_name = $_SERVER["SCRIPT_NAME"]."?id=".$_GET['id'];
		if($_GET['er'] == "loginerror") print("<script language=javascript> if(confirm('Такого пользователя нет! Хотите зарегистрироваться?')){ window.location = 'checkout.php'; } else { window.location = '".$site_name."'; }</script>");
		if($_GET['er'] == "passerror") print("<script language=javascript>window.alert('Вы ввели неправильный пароль!');window.location = 'index.php';</script>");
		if($_GET['er'] == "empty") print("<script language=javascript>window.alert('Заполните все поля!');window.location = 'index.php';</script>");
	}

?>