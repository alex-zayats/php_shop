<?php
include_once ("../views/admin-header.php");
?>

<form id="login-admin" action="http://localhost/iba/user/login-admin" method="post">
	<label>Логин:</label>
	<input name="login" type="text" size="20" placeholder="Логин" maxlength="30"><br>
	<label>Пароль:</label>
	<input name="pass" type="password" size="20" placeholder="Пароль" maxlength="50"><br>
	<input type="submit" value="Войти">
</form>

<?php 
include_once ("../views/footer.php");