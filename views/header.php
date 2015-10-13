<?php session_start ();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css"
	href="http://localhost/iba/style/style.css">
<script src="http://localhost/iba/js/jquery-2.1.3.min.js"></script>
<title><?php if (isset($GLOBALS['title'])) echo $GLOBALS['title']; else echo "Seller.com" ?></title>
<link rel="shortcut icon" href="http://localhost/iba/images/favicon.png"
	type="image/png">
</head>
<body>
	<div id="wrapper">
		<hgroup>
			<h1 class="site-title">
				<a href="http://localhost/iba/" title="Seller" rel="home">Seller.com</a>
			</h1>
			<h2 class="site-description">Сайт по продаже одежды и обуви</h2>
		</hgroup>
		<div id="upper">
		<div id="login">
		<?php
		if (isset ( $_SESSION ['id_user'] )) {
			?>
			<button id="profile"><a href='http://localhost/iba/user-profile'>Настройки профиля</a></button>
			<button id="logout"><a href='http://localhost/iba/user/logout'>Выйти</a></button>
			</div>
		<?php } else {?>
			<form action="http://localhost/iba/user/login" method="post">
				<input name="login" type="text" size="20" placeholder="Логин"
					maxlength="30"><br> <input name="pass" type="password" size="20"
					placeholder="Пароль" maxlength="50"><br> <input type="submit"
					value="Войти">
			</form>
			</div>
			<button id="registration">
				<a href="http://localhost/iba/registration">Зарегистрироваться!</a>
			</button>
		<?php }?>
		</div>
		<header id="header">
			<nav id="site-navigation" role="navigation">
				<div class="nav-menu">
					<ul>
						<li><a href="http://localhost/iba/">Главная</a></li>
						<li><a href="http://localhost/iba/category/1">Женский раздел</a></li>
						<li><a href="http://localhost/iba/category/2">Мужской раздел</a></li>
						<li><a href="http://localhost/iba/category/3">Детский раздел</a></li>
						<li><a href="http://localhost/iba/contacts">Контакты</a></li>
						<li><a href="http://localhost/iba/cart">Корзина</a></li>
					</ul>
				</div>
			</nav>
		</header>


		<div id="page">