<?php

	include_once("../functions/admin_function.php");

	session_start();

	if(isset($_POST['login'])){
		$admins = get_admin($_POST['login']);
		if(isset($admins) and $admins != false){
			$_SESSION['administrator'] = $_POST['login'];
			header("location: admin.php?orders");
		}
		else{
			session_destroy();
			header("location: index.php");
			exit();
		}
	}

	if(isset($_GET['logout'])){
		session_destroy();
		header("location: index.php");
		exit();
	}
?>