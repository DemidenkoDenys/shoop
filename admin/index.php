<?php

	include_once("../functions/admin_function.php");

	// ini_set('display_errors', 1);
	// error_reporting(E_ALL);

	session_start();


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Панель администратора</title>

	<link rel="stylesheet" href="style-admin.css">
</head>
<body>
	<div class="auth">
		<form action="auth_admin.php" method="post">
			<h1>Авторизация</h1>
			<label for="login">Логин<input type="text" id="login" name="login" required></label>
			<label for="password">Пароль<input type="password" id="password" name="password" required></label>
			<div class="enter"><input type="submit" value="Вход"></div>
		</form>
	</div>
</body>
</html>