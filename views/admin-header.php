<?php
session_start();
include_once ("../views/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css"
	href="http://localhost/iba/style/style.css">
<title>Админ-панель</title>
<link rel="shortcut icon" href="http://localhost/iba/images/favicon.png"
	type="image/png">
</head>
<body>
	<div id="wrapper">
		<hgroup>
			<h1 class="site-title">
				<a href="http://localhost/iba/" title="Seller" rel="home">Seller.com</a>
			</h1>
			<h2 class="site-description">Редактирование сайта</h2>
		</hgroup>
		<div id="login">
		<?php if (isset ( $_SESSION ['id_admin'] )) {?>
			<button><a href="http://localhost/iba/user/logout-admin">Выйти</a></button>
		<?php }?>
		</div>
		<header id="header">
			<nav id="site-navigation" role="navigation">
				<div class="nav-menu">
					<ul>
						<li><a href="http://localhost/iba/admin-goods">Товары</a></li>
						<li><a href="http://localhost/iba/admin-categories">Категории</a></li>
						<li><a href="http://localhost/iba/admin-users">Пользователи</a></li>
						<li><a href="http://localhost/iba/admin-purchases">Покупки</a></li>
					</ul>
				</div>
			</nav>
		</header>


		<div id="page">