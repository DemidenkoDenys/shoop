<?php

	include_once("functions/function.php");

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	session_start();

	// если покупатель авторизован
	if(!isset($_SESSION['login'])){
		session_destroy();
		// header("location: index.php");
	}
	else{
		$current_customer = get_customers($_SESSION['login']);	// получаем данные покупатедя
		$order = get_order($current_customer[0]['id'], true);	// получаем данные о его неоплаченных покупках

		if(isset($order) and $order != false){
			$sumOrder = get_orderSum($order[0]['id']);			// получаем суммы по предзаказу
			$order = get_order($order[0]['id'],false);			// получаем список товаров в неоплаченной покупке
		}
		else
			$sumOrder = 0;
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

				if(isset($_SESSION['login']))
					echo '<p class="name green">'.$current_customer[0]['name'].'
							<a class="logout" href="auth.php?logout=false"><img src="img/logout.png" alt="Выйти"></a></p>
							<a href="show_cart.php"><h1>Ваша корзина</h1></a>';
				else
					echo '<h1 class="green" align="right">Регистрация</h1>';

			?>

		</div>
	</div>

	<?php

		if(isset($_SESSION['login'])){
			echo '	<div class="carts">
					<p class="green">Убедитесь, что покупки выбраны правильно</p>
					<table>
						<tr class="table-header">
							<td width="60%">Категория</td>
							<td width="15%">Цена</td>
							<td width="10%">Количество</td>
							<td width="15%">Всего</td>
						</tr>';

			for ($i = 0; $i < count($order); $i++)
				echo '	<tr class="table-equip minimal">
							<td align="left"><a href="show_equip.php?id='.$order[$i]['idequip'].'">'.$order[$i]['name'].'</a></td>
							<td>'.$order[$i]['price'].' грн.</td>
							<td>'.$order[$i]['amount'].'</td>
							<td>'. sprintf('%0.2f', $order[$i]['price'] * $order[$i]['amount']).' грн.</td>
						</tr>';

			if(isset($sumOrder) and $sumOrder != false)
				echo '	<tr class="table-footer">
							<td colspan="2">ИТОГО:</td>
							<td>'.$sumOrder[0]['count'].'</td>
							<td>'.$sumOrder[0]['total'].' грн.</td>
						</tr>

						<tr class="delivery green">
							<td colspan="3" align="left">ДОСТАВКА</td>
							<td align="right">72 грн.</td>
						</tr>

						<tr class="table-footer-total green">
							<td colspan="3" align="left">ВСЕГО ВКЛЮЧАЯ ДОСТАВКУ:</td>
							<td align="right">'.($sumOrder[0]['total'] + 72).' грн.</td>
						</tr>';

			echo '	</table>
					<form action="process.php" method="post" autocomplete="off">
					<input class="purchase-button button" type="submit" value="Оплатить">
					<p class="specs">Нажав кнопку "Оплатить", вы соглашаетесь с <a href="#">условиями купли/продажи.</a> При этом с указанной Вами карточки будет снято '.($sumOrder[0]['total'] + 72).' грн</p>';

			echo '	<div class="info-user">
						<p>Введите информацию о карточке</p>
						
							<label for="type-cart">Тип
								<select name="type-cart" id="type-cart">
									<option value="1">MasterCart</option>
									<option value="2">Visa</option>
									<option value="3">Electron</option>
								</select>
							</label>

							<label for="nomer">Номер<input id="nomer" name="nomer" type="text" value="" pattern="(\d{4}\s){3}\d{4}" title="XXXX XXXX XXXX XXXX"  placeholder="XXXX XXXX XXXX XXXX" required></label>
							<label for="amex">CVV-код<input id="cvv" name="cvv" class="little" type="text" value="" pattern="\d{3}" title="XXX" placeholder="CVV-код" required></label>
							<label class="month" for="month">Месяц<input id="month" name="month" list="dlmonth" class="little" type="text" value="" placeholder="Месяц" required><datalist id="dlmonth"><option value="1">Январь</option><option value="2">Февраль</option><option value="3">Март</option><option value="4">Апрель</option><option value="5">Май</option><option value="6">Июнь</option><option value="7">Июль</option><option value="8">Август</option><option value="9">Сентябрь</option><option value="10">Октябрь</option><option value="11">Ноябрь</option><option value="12">Декабрь</option></datalist>-год
							<input id="year" list="dlyear" name="year" class="little" type="text" value="" pattern="\d{4}" title="XXXX" placeholder="Год" required><datalist id="dlyear">';
							for ($i = date('Y') - 20, $l = 20; $l >= 0; $l--, $i++)
								echo '<option>'.$i.'</option>';
			echo 			'</datalist></label>
							<label for="vladelec">Владелец карточки<input id="vladelec" name="vladelec" type="text" value="'.$current_customer[0]['name'].'" placeholder="ФИО владельца" pattern="([А-ЯЁ][а-яё]+[\s]?){3}" title="Фамилия Имя Отчество" required></label>
						</div></form>';
		}

		else{
			echo'<div class="info-user">
				<p>Введите информацию о себе</p>
				<form action="registration.php" method="post" autocomplete="off">
					<label for="fio">ФИО<input id="fio" name="fio" type="text" value="" placeholder="Фамилия Имя Отчество" title="Фамилия Имя Отчество" pattern="([А-ЯЁ][а-яё]+[\s]?){3}" required></label>
					<label for="strana">Страна<input id="strana" name="strana" list="dlstrana" value="" placeholder="Страна" title="Одним словом" required><datalist id="dlstrana">';
					$data = get_customersdata("country");
					for($i = 0; $i < count($data); $i++) echo '<option>'.$data[$i]['country'].'</option>';
			echo	'</datalist></label><label for="gorod">Город/Село<input id="gorod" name="gorod" list="dlgorod" value="" placeholder="Город" title="Одним словом" required><datalist id="dlgorod">';
					$data = get_customersdata("city");
					for($i = 0; $i < count($data); $i++) echo '<option value="'.$data[$i]['city'].'">'.$data[$i]['country'].'</option>';
			echo	'</datalist></label><label for="oblast">Область<input id="oblast" name="oblast" list="dloblast" value="" placeholder="Область" title="Одним словом" required><datalist id="dloblast">';
					$data = get_customersdata("state");
					for($i = 0; $i < count($data); $i++) echo '<option value="'.$data[$i]['state'].'">'.$data[$i]['city'].'</option>';
			echo	'</datalist></label><label for="zip">Почтовый индекс<input id="zip" name="zip" list="dlzip" value="" placeholder="Почтовый индекс" pattern="\d{5}(\s\d{4})?" title="XXXXX XXXX" required><datalist id="dlzip">';
					$data = get_customersdata("zip");
					for($i = 0; $i < count($data); $i++) echo '<option value="'.$data[$i]['zip'].'">'.$data[$i]['state'].'</option>';
			echo	'</datalist></label><label for="adres">Адрес<input id="adres" name="adres" type="text"value="" placeholder="Адрес проживания" required></label><br>
					<label for="strana">Логин<input id="login" name="login" type="text" value="" placeholder="Введите логин" required></label>
					<label for="strana">Пароль<input type="password" id="password" name="password" value="" placeholder="Введите пароль" required></label>
					<input type="submit" class="register-button button" value="Зарегистрироваться">
				</form>
			</div>';
		}
	?>

		
	</div>

	<div class="back">
		<a href="show_cart.php"><img src="img/back.png" alt=""></a>
		<p class="green">Вернуться к покупкам</p>
	</div>
</body>
</html>