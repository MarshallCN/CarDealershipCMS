<?php
	session_start();
	require "include/db.php";
	include "include/header.html";
	include "include/navigation.php";
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = 'home';
	}
	if($page=='home'){ //show pages
		include "app/home.php";
	}else if($page=='carlist'){
		include "app/car_list.php";
	}else if($page=='car'){
		include "app/car.php";
	}else if($page=='list'){
		include "app/article_list.php";
	}else if($page=='article'){
		include "app/article.php";
	}else if($page=='contact'){
		include "app/contact.php";
	}else if($page=='profile'&&isset($_SESSION['user'])){
		include "app/profile.php";
	}else if($page=='drive'){
		include "app/drive.php";
	}else{
		include "app/home.php";
	}
	if(isset($_GET['logout'])){ //logout
		unset($_SESSION['user']);
		unset($_SESSION['userid']);
		unset($_SESSION['avatar']);
		session_destroy();
		redirect('index.php');
	}
	include "include/footer.html";
?> 

