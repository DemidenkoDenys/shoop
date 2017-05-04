<?php 
	include_once("functions/function.php");

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();

	// валидация ID категории
	if(isset($_GET['id'])){
		if(!is_numeric($_GET['id'])) header("location: index.php"); // если ID категории не число
		if(!get_equipments($_GET['id'], false)) header("location: index.php"); // если такой категории не существует
		$equipments = get_equipments($_GET['id'], false); // получаем данные о товаре
	}
	else{
		if(isset($_SESSION['login'])){
			$_GET['id'] = $_SESSION['current_equipment'];
			$equipments = get_equipments($_SESSION['current_equipment'], false); // получаем список всех товаров
		}
		else header("location: index.php"); // нет данных для загрузки категории, возвращаеммся на главную
	} // валидация ID категории УСПЕШНА

	// если покупатель авторизован
	if(!isset($_SESSION['login'])){
		session_destroy();
	}
	else{
		$current_customer = get_customers($_SESSION['login']);	// получаем данные покупатедя
		$order = get_order($current_customer[0]['id'], true);

		if(isset($order) and $order != false) 
			$sumOrder = get_orderSum($order[0]['id']);

		if($equipments != false and isset($equipments))				// если список товаров существует
			$_SESSION['current_equipment'] = $equipments[0]['id'];	// заносим ID категории в сессию
	}

	$current_category = $equipments[0]['idcategory'];
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
					echo	'<p class="name green">'.$current_customer[0]['name'].'
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

	<div class="equipment">

		<?php
			if(isset($_SESSION['login']))
				echo '<a class="button" href="add_orderitem.php?id='.$equipments[0]['id'].'">Добавить в корзину</a>';
			else
				echo '<a class="button disabled">Войдите, чтобы добавить</a>';

			if(isset($equipments)){
				if($equipments != false)
				{
					echo '<h1>'.$equipments[0]['name'].'</h1>';
					echo '<img src="img/equipments/'.$equipments[0]['image'].'" alt="'.$equipments[0]['name'].'">';
					echo '<h2>'.$equipments[0]['price'].' грн</h2>';
					echo '<p>'.formchar($equipments[0]['description']).'</p>';
				}
			}
		?>

	</div>

	<div class="back">
		<a href="show_cat.php?id=<?php echo $current_category; ?>"><img src="img/back.png" alt=""></a>
		<p class="green">Вернуться к товарам</p>
	</div>
</body>
</html>

<?php
	// выводим ошибки, если они есть
	if(isset($_GET['er'])){
		$site_name = $_SERVER["SCRIPT_NAME"]."?id=".$_GET['id'];
		if($_GET['er'] == "loginerror") print("<script language=javascript> if(confirm('Такого пользователя нет! Хотите авторизоваться?')){ window.location = 'checkout.php'; } else { window.location = '".$site_name."'; }</script>");
		if($_GET['er'] == "passerror") print("<script language=javascript>window.alert('Вы ввели неправильный пароль!'); window.location = '".$site_name."';</script>");
		if($_GET['er'] == "empty") print("<script language=javascript>window.alert('Заполните все поля!'); window.location = '".$site_name."';</script>");
	}
?>