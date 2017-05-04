<?php

	include_once("functions/function.php");

	// ini_set('display_errors', 1);
	// error_reporting(E_ALL);

	session_start();

	// если покупатель авторизован
	if(!isset($_SESSION['login'])){
		session_destroy();
		header("location: index.php");
	}
	else{
		$current_customer = get_customers($_SESSION['login']);	// получаем данные покупатедя
		$order = get_order($current_customer[0]['id'], true);	// получаем данные о его неоплаченных покупках

		if(isset($order) and $order != false)
			$order = get_order($order[0]['id'], false);			// получаем список товаров в неоплаченной покупке
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
			<p class="name green"><?php echo $current_customer[0]['name']; ?>
				<a class="logout" href="auth.php?logout=false"><img src="img/logout.png" alt="Выйти"></a>
			</p>
		</div>
	</div>

	<div class="carts">
		<h1>Ваша корзина</h1>
		<form action="update_orderitem.php" method="post" autocomplete="off">
			<table>
				<tr class="table-header">
					<td colspan="2" width="70%">Категория</td>
					<td width="10%">Цена</td>
					<td width="10%">Количество</td>
					<td width="10%">Всего</td>
				</tr>

				<?php

					if(isset($order) and $order != false){
						for ($i = 0; $i < count($order); $i++) {
							$blink = ''; if(isset($_GET['id']) and $order[$i]['idequip'] == $_GET['id']) $blink = ' blink';
							echo'<tr class="table-equip '.$blink.'"><td width="10%"><a href="show_equip.php?id='.$order[$i]['idequip'].'"><img src="img/equipments/'.$order[$i]['image'].'" alt="'.$order[$i]['name'].'"></a></td><td align="left"><a href="show_equip.php?id='.$order[$i]['idequip'].'">'.$order[$i]['name'].'</a></td><td>'.$order[$i]['price'].'</td><td><input class="amount" name="orderitem'.$order[$i]['idequip'].'" onchange="getSum(this)" type="number" value="'.$order[$i]['amount'].'" min="0"></td><td>'.sprintf('%0.2f', $order[$i]['price'] * $order[$i]['amount']).'</td></tr>';
						}
						echo '</table><input type="submit" id="save-change" onclick="enable(this)" class="button disabled" value="Сохранить"><a class="checkout-button button" href="checkout.php">Оформить счет<img src="img/cart.png" alt=""></a>';
					}
					else{
						$order = get_data(' SELECT orders.id, orders.date, 
											SUM(orderitem.amount * equipments.price) AS total,
											SUM(orderitem.amount) AS count
											FROM orders, orderitem, equipments
											WHERE orders.status = 1
											AND orders.id = orderitem.id 
											AND orders.idcustomer = '.$current_customer[0]['id'].'
											AND orderitem.idequipment = equipments.id 
											GROUP BY orders.id');
						for ($i = 0; $i < count($order); $i++)
							echo'<tr class="disabled" style="color: grey"><td width="10%"></td><td align="left"><p>Обработанный заказ '.$order[$i]['date'].'</p></td><td></td><td>'.$order[$i]['count'].' шт.</td><td>'.$order[$i]['total'].' грн</td></tr>';
						echo '<tr class="table-equip"><td colspan="4">Нет выбранных товаров. Хотите <a href="index.php">перейти к категориям товаров</a>, чтобы сделать покупку?</tr></table>';
					}
				?>
		</form>
	</div>

	<div class="back">
		<a href="index.php"><img src="img/back.png" alt=""></a>
		<p class="green">Вернуться в магазин</p>
	</div>

	<script type="text/javascript">

		function getSum(obj){
			var amount = obj.value;
			var price = parseFloat(obj.parentNode.previousSibling.innerHTML);
			obj.parentNode.nextSibling.innerHTML = parseFloat(amount * price).toFixed(2);
			document.getElementById('save-change').classList.remove('disabled');
		}

		function enable(obj){ obj.classList.add('disabled'); }

		function verifyClose(){
			if(!document.getElementById('save-change').classList.contains('disabled'))
				event.returnValue = "Вы изменили значения количества покупаемых товаров!\nПОСЛЕ ВЫХОДА ДАННЫЕ НЕ БУДУТ СОХРАНЕНЫ!\n\nЧтобы сохранить значения, нажмите кнопку 'Сохранить'!";
		}

		window.onbeforeunload = function(){ return verifyClose(); }

	</script>
</body>
</html>