<?php
	session_start();
	require "../include/db.php";
	//error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	if(!isset($_SESSION['admin'])){
		header("Location:login.php");
	}
	if(isset($_GET['exit'])){
		unset($_SESSION['admin']);
		unset($_SESSION['adminid']);
		session_destroy();
		header("Location:login.php");
	}
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}else{
		$page = 'dashboard';
	}
	if(isset($_GET['action'])){
		$url = 'index.php?page='.$page.'&action='.$_GET['action'];
	}else{
		$url = 'index.php?page='.$page;
	}
	/* Access Check */
	$sql_access = "SELECT access FROM admin_menu AS m INNER JOIN access AS a ON m.id=a.menu_id WHERE URL='$url' AND role_id={$_SESSION['role']}";
	$isaccess = $mysql->oneQuery($sql_access);
	if(empty($isaccess)){
		header("Location:index.php");
		echo "<script>alert('Access Denied!');history.go(-1)</script>";
	}
	/* include pages */
	include "include/header.html";
	include "include/adminnav.php";
	if($page=='dashboard'){//Show pages
		include "app/dashboard.php";
	}else if($page=='content'){
		$action=(isset($_GET['action']))? $_GET['action']:'article';
		if($action=='article'){
			include "app/content.php";
		}else{
			include "app/site_menu.php";
		}
	}else if($page=='car'){
		include "app/car.php";
	}else if($page=='customer'){
		include "app/customer.php";
	}else if($page=='system'){
		$action=(isset($_GET['action']))? $_GET['action']:'menu';
		if($action=='user'){
			include "app/user.php";
		}else if($action=='log'){
			include "app/systemlog.php";
		}else if($action=='menu'){
			include "app/admin_menu.php";
		}else if($action=='role'){
			include "app/role.php";
		}
	}else if($page=='contact'){
		include "app/contact.php";
	}
	include "include/footer.html";
?>