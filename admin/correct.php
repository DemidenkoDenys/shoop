<?php
	include_once("../functions/admin_function.php");

	session_start();
	if(!isset($_SESSION['administrator'])){ 
		session_destroy();
		header("location: index.php");
		exit();
	}

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	if(isset($_GET))
	{
		if(isset($_GET['equipments'])){
			delete_equipments($_GET['id']);
			header('location: admin.php?equipments');
			exit();
		}

		if(isset($_GET['customers'])){
			delete_customers($_GET['id']);
			header('location: admin.php?customers');
			exit();
		}

		if(isset($_GET['categories'])){
			delete_category($_GET['id']);
			header('location: admin.php?categories');
			exit();
		}

	}

	if(isset($_POST))
	{
		if(isset($_POST['password']) and isset($_POST['id'])){
			correct_password($_POST['password'], $_POST['id']);
			header('location: admin.php?customers');
			exit();
		}


		if(isset($_POST['description']) and isset($_POST['cost']) and isset($_POST['category-add']) and isset($_POST['add-name']) and $_FILES){
			copy($_FILES['image']['tmp_name'],"../img/equipments/".$_FILES['image']['name']); // копируем файл
			add_equipment($_POST['add-name'], $_POST['category-add'], $_POST['cost'], $_POST['description'], $_FILES['image']['name']);
			header('location: admin.php?equipments');
			exit();
		}

		if(isset($_POST['add-name-cat']) and $_FILES){
			copy($_FILES['image-cat']['tmp_name'],"../img/categories/".$_FILES['image-cat']['name']); // копируем файл
			add_category($_POST['add-name-cat'], $_FILES['image-cat']['name']);
			header('location: admin.php?categories');
			exit();
		}
	}
?>