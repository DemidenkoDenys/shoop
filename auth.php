<?php
	include_once("functions/function.php");
	session_start(); if(!isset($_SESSION['login'])) session_destroy();

	// определяем адрес страницы, откуда был переход
	$site_referrer = substr($_SERVER['HTTP_REFERER'], strripos($_SERVER['HTTP_REFERER'], '/') + 1);

	if(isset($_GET['logout']) and $_GET['logout'] == 'true') { session_destroy(); header("location: ".$site_referrer); exit(); }
	if(isset($_GET['logout']) and $_GET['logout'] == 'false') { session_destroy(); header("location: index.php"); exit(); }

	if($site_referrer == '') $site_referrer = 'index.php';
	// если GET запрос уже был, то добавляемм & в конец для GET['er'] запроса об ошибке
	$amp = '?'; if(stripos($_SERVER['HTTP_REFERER'], "?") != false) $amp = '&';

	// если ввели название скрипта руками
	if(!isset($_POST['login']) or !isset($_POST['password'])){ header("location: ".$site_referrer); exit(); }

	// если не POST переменные пустые
	if($_POST['login'] == '' or $_POST['password'] == ''){ header("location: ".$site_referrer.$amp."er=empty"); exit(); }

	$user = get_customers($_POST['login']); // получаем данные покупателя

	// если нет такого пользователя
	if($user == false){ header("location: ".$site_referrer.$amp."er=loginerror"); exit(); }

	// если пароль пользователя не совпадает
	if($user[0]['password'] != $_POST['password']){ header("location: ".$site_referrer.$amp."er=passerror"); exit(); }

	session_start();						// запускаем сессию
	$_SESSION['login'] = $_POST['login'];	// вводим логин в параметр сессии
	unset($_POST['password']); 				// очищаем пост-переменные
	unset($_POST['login']);					// очищаем пост-переменные
	header("location: ".$site_referrer);	// возвращаемся на главную



?>