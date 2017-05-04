<?php 
	include_once("functions/function.php");

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();

	// валидация ID категории
	if(isset($_GET['id'])){
		if(!is_numeric($_GET['id'])) header("location: index.php"); // если ID категории не число
		if(!get_categories($_GET['id'])) header("location: index.php"); // если такой категории не существует
		$equipments = get_equipments($_GET['id'], true); // получаем список всех категорий
	}
	else{
		if(isset($_SESSION['login'])){
			$_GET['id'] = $_SESSION['current_category'];
			$equipments = get_equipments($_SESSION['current_category'], true); // получаем список всех категорий
		}
		else header("location: index.php"); // нет данных для загрузки категории, возвращаеммся на главную
	} // валидация ID категории УСПЕШНА

	// если покупатель авторизован
	if(!isset($_SESSION['login'])){
		session_destroy();
	}
	else{
		$current_customer = get_customers($_SESSION['login']); // получаем данные покупатедя
		$order = get_order($current_customer[0]['id'], true);

		if(isset($order) and $order != false) 
			$sumOrder = get_orderSum($order[0]['id']);

		if($equipments != false and isset($equipments))		   // если список товаров существует
			$_SESSION['current_category'] = $equipments[0]['idcategory'];	// заносим ID категории в сессию
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Магазин стеклянной посуды Shoop</title>

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
		<p class="green">Категория: "Вазы"</p>

		<?php
			if($equipments != false)
			{
				echo '<p>Выберите товар...</p>';

				echo '<ul>';
				for ($i = 0; $i < count($equipments); $i++)
					echo '<li><a href="show_equip.php?id='.$equipments[$i]['id'].'"><img src="img/equipments/'.$equipments[$i]['image'].'" alt="'.$equipments[$i]['name'].'"><p>'.$equipments[$i]['name'].'</p></a></li>';
				echo '</ul>';
			}
			else
				echo '<p>Нет ни одного товара!</p>';
		?>

	</div>

	<div class="back">
		<a href="index.php"><img src="img/back.png" alt=""></a>
		<p class="green">Вернуться к категориям</p>
	</div>

</body>
</html>

<?php
	// выводим ошибки, если они есть
	if(isset($_GET['er'])){
		$site_name = $_SERVER["SCRIPT_NAME"]."?id=".$_GET['id'];
		if($_GET['er'] == "loginerror") print("<script language=javascript> if(confirm('Такого пользователя нет! Хотите зарегистрироваться?')){ window.location = 'checkout.php'; } else { window.location = '".$site_name."'; }</script>");
		if($_GET['er'] == "passerror") print("<script language=javascript>window.alert('Вы ввели неправильный пароль!'); window.location = '".$site_name."';</script>");
		if($_GET['er'] == "empty") print("<script language=javascript>window.alert('Заполните все поля!'); window.location = '".$site_name."';</script>");
	}
?>