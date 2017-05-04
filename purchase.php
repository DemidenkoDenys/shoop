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
		<a href="#" class="logo">
			<!-- <img src="img/logo.png" alt="Магазин ..."> -->
		</a>

		<div class="cart">
			<p class="name">Иван Моргун Гурубожчанколикович
				<a class="logout" href="#"><img src="img/logout.png" alt="Выйти"></a>
			</p>
			<a href="#"><h1>Ваша корзина</h1></a>
		</div>
	</div>

	<div class="carts">
		<p class="green">Убедитесь, что покупки выбраны правильно</p>
		<table>
			<tr class="table-header">
				<td width="60%">Категория</td>
				<td width="15%">Цена</td>
				<td width="10%">Количество</td>
				<td width="15%">Всего</td>
			</tr>
			<tr class="table-equip minimal">
				<td align="left"><a href="">Велотренажер такой-то такой-то LJBVLS-1293hg</a></td>
				<td>190 грн.</td>
				<td>1</td>
				<td>190 грн.</td>
			</tr>
			<tr class="table-equip minimal">
				<td align="left"><a href="">Велотренажер такой-то такой-то LJBVLS-1293hg</a></td>
				<td>190 грн.</td>
				<td>1</td>
				<td>190 грн.</td>
			</tr>
			<tr class="table-equip minimal">
				<td align="left"><a href="">Велотренажер такой-то такой-то LJBVLS-1293hg</a></td>
				<td>190 грн.</td>
				<td>1</td>
				<td>190 грн.</td>
			</tr>
			<tr class="table-equip minimal">
				<td align="left"><a href="">Велотренажер такой-то такой-то LJBVLS-1293hg</a></td>
				<td>190 грн.</td>
				<td>1</td>
				<td>190 грн.</td>
			</tr>
			<tr class="table-equip minimal">
				<td align="left"><a href="">Велотренажер такой-то такой-то LJBVLS-1293hg</a></td>
				<td>190 грн.</td>
				<td>1</td>
				<td>190 грн.</td>
			</tr>
			<tr class="table-footer">
				<td colspan="2">ИТОГО:</td>
				<td>12</td>
				<td>190 грн.</td>
			</tr>
			<tr class="delivery green">
				<td colspan="3" align="left">ДОСТАВКА</td>
				<td align="right">72 грн.</td>
			</tr>
			<tr class="table-footer-total green">
				<td colspan="3" align="left">ВСЕГО ВКЛЮЧАЯ ДОСТАВКУ:</td>
				<td align="right">262 грн.</td>
			</tr>
		</table>

		<a class="purchase-button button" href="#">Оплатить<img src="img/cart.png" alt=""></a>
		<p class="specs">Нажав кнопку "Оплатить", вы соглашаетесь с <a href="#">условиями купли/продажи.</a> При этом с указанной Вами карточки будет снято <b>262 грн.</b></p>
		<div class="info-user">
			<p>Введите информацию о карточке</p>
			<form action="">
				<label for="type-cart">Тип
					<select name="type-cart" id="type-cart">
						<option value="1">MasterCart</option>
						<option value="2">Visa</option>
						<option value="3">Electron</option>
					</select>
				</label>
				<label for="nomer">Номер<input id="nomer" type="text" value=""></label>
				<label for="amex">AMEX-код<input id="amex" class="little" type="text" value=""></label>
				<label class="month" for="month">Месяц <input id="month" class="little" type="text" value=""/> год<input id="year" class="little" type="text" value=""/></label>
				<label for="vladelec">Владелец карточки<input id="vladelec" type="text"value=""></label>
			</form>
		</div>
	</div>

	<div class="back">
		<img src="img/back.png" alt="">
		<p class="green">Вернуться к категориям</p>
	</div>
</body>
</html>