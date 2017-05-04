<?php

	include_once("../functions/admin_function.php");

	// ini_set('display_errors', 1);
	// error_reporting(E_ALL);

	session_start();

	if(!isset($_SESSION['administrator'])){
		session_destroy();
		header("location: index.php");
	}

	$orders = get_orders();
	$categories = get_categories();
	$equipments = get_equipments();
	$customers = get_customers();

	$panel = 'none';
	if(isset($_GET)){
		if(isset($_GET['orders'])) $panel = 'orders';
		if(isset($_GET['categories'])) $panel = 'categories';
		if(isset($_GET['equipments'])) $panel = 'equipments';
		if(isset($_GET['customers'])) $panel = 'customers';
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Панель администратора</title>

	<link rel="stylesheet" href="style-admin.css">
</head>
<body>
	<div class="header">
		<a href="#" class="logo"></a>

		<div class="cart">
			<p class="name green"><?php echo 'Администратор: '.$_SESSION['administrator']; ?>
				<a class="logout" href="auth_admin.php?logout"><img src="../img/logout.png" alt="Выйти"></a>
			</p>
			<a class="cart-button button" href="../index.php">На сайт<img src="../img/logo2.png" alt=""></a>
		</div>
	</div>

	<div class="container">
		<table class="menu head" border="0">
			<tr>
				<td width="25%"><a href="admin.php?orders">Заказы</a></td>
				<td width="25%"><a href="admin.php?categories">Категории</a></td>
				<td width="25%"><a href="admin.php?equipments">Товары</a></td>
				<td width="25%"><a href="admin.php?customers">Пользователи</a></td>
			</tr>
		</table>

		<?php

			// =============== ORDERS ===============//
			if($panel == 'orders'){
				echo '<table class="order"><tr class="head"><td width="20%">Номер заказа</td><td width="25%">Фамилия Имя Отчество</td><td width="40%">Страна, город, адрес</td><td width="15%">Сумма заказа</td></tr>';

				for ($i = 0; $i < count($orders); $i++){
					$closed = ''; if($orders[$i]['status'] == 1) $closed = ' class="closed"';
					echo '	<tr'.$closed.'><td>'.$orders[$i]['id'].' ('.$orders[$i]['date'].')</td>
								<td>'.$orders[$i]['name'].'</td>
								<td>'.$orders[$i]['adres'].'</td>
								<td>'.$orders[$i]['total'].' грн. ('.$orders[$i]['count'].' шт.)</td></tr>';
				}
				echo '</table>';
			}

			//============= CATEGORY ================//
			if($panel == 'categories'){

				echo '<form action="correct.php" method="post" enctype="multipart/form-data" autocomplete="off"><table class="category"><tr class="head"><td width="10%">Номер категории</td><td width="80%">Название категории</td><td width="7%">Действие</td></tr>';

				for ($i = 0; $i < count($categories); $i++)
					echo '<tr><td>'.$categories[$i]['id'].'</td><td>'.$categories[$i]['name'].'</td><td align="center"><a href="correct.php?categories&id='.$categories[$i]['id'].'">удалить</a></td></tr>';

				echo '<tr><td><img id="load-cat" src="../img/loadfile.png" onclick="loadPicture(this, true)">
						<input id="picture-cat" name="image-cat" type="file" accept="image/jpeg,image/png,image/gif" required></td>
					<td class="input"><input name="add-name-cat" type="text" value="" placeholder="введите название" required></td>
					<td><input class="reset-submit" type="submit" value="добавить"></td>
				</tr></table></form>';
			}

			//============= EQUIPMENTS ================//

			if($panel == 'equipments'){

				echo '<form action="correct.php" method="post" enctype="multipart/form-data" autocomplete="off"><table class="goods"><tr class="head"><td width="3%">ID</td><td width="10%">Картинка</td><td width="25%">Название</td><td width="15%">Категория</td><td width="35%">Описание</td><td width="10%">Цена</td><td width="10%">Действие</td></tr>';

				for ($i = 0; $i < count($equipments); $i++)
					echo '<tr><td>'.$equipments[$i]['id'].'</td><td align="center"><img src="../img/equipments/'.$equipments[$i]['image'].'" alt=""></td><td>'.$equipments[$i]['name'].'</td><td>'.$equipments[$i]['category'].'</td><td><p>'.$equipments[$i]['description'].'</p></td><td>'.$equipments[$i]['price'].' грн.</td><td align="center"><a href="correct.php?equipments&id='.$equipments[$i]['id'].'">удалить</a></td></tr>';

				echo '<tr><td></td><td align="center"><img id="load" src="../img/loadfile.png" onclick="loadPicture(this, false)">
				<input id="picture" name="image" type="file" accept="image/jpeg,image/png,image/gif" required></td><td class="input"><input name="add-name" type="text" value="" placeholder="введите название" required></td><td class="input"><select name="category-add" id="category-add" multiple>';

				for ($i = 0; $i < count($categories); $i++)
					echo '<option value="'.$categories[$i]['id'].'">'.$categories[$i]['name'].'</option>';

				echo '</select></td>
				<td class="textarea-field">
					<textarea name="description" cols="30" rows="10"></textarea>
				</td>
				<td class="input">
					<input name="cost" type="number" value="" min="0" placeholder="введите стоимость">
				</td>
				<td>
					<input class="reset-submit" type="submit" value="добавить"></td></tr></table></form>';
			}

			//============= CUSTOMERS ================//
			if($panel == 'customers'){

				echo '<table class="users"><tr class="head"><td width="5%">ID</td><td width="30%">ФИО</td><td width="15%">Логин</td><td width="30%">Новый пароль</td><td width="10%" align="center">Удалить</td></tr>';

				for ($i = 0; $i < count($customers); $i++)
					echo '<tr><td>'.$customers[$i]['id'].'</td><td>'.$customers[$i]['name'].'</td><td>'.$customers[$i]['login'].'</td><td class="input"><form action="correct.php" method="post" autocomplete="off"><input class="reset-id" type="text" name="id" value="'.$customers[$i]['id'].'" required><input class="reset-password" type="text" name="password" placeholder="введите новый пароль" required><input class="reset-submit" type="submit" value="сохранить"></form></td><td align="center"><a href="correct.php?customers&id='.$customers[$i]['id'].'">удалить</a></td></tr>';

				echo '</table></div>';
			}

			if($panel == 'none')
				echo 'Выберите панель администратора';
		?>

	<script>

		function loadPicture(obj, cat){
			if(cat) var picture = document.getElementById('picture-cat');
			else var picture = document.getElementById('picture');
			picture.click();

			picture.onchange = function(){
				var reader = new FileReader();
				reader.onload = function(e){ obj.src = e.target.result; }
				reader.readAsDataURL(this.files[0]);
			}
		}

	</script>
</body>
</html>
