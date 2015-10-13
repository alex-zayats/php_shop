<?php
include_once ("../models/users.php");
include_once ("../views/functions.php");

$GLOBALS ['title'] = "Регистрация";

include_once ("header.php");
?>
<h2>Форма регистрации</h2>

<form name="registration" action="http://localhost/iba/user/register" method="post">

 <label>Ваше имя:</label>
 <input type="text" id="name" name="name" maxlength="25" required>

 <label>Фамилия:</label>
 <input type="text" id="surname" name="surname" maxlength="25" required>

 <label>Email:</label>
 <input type="email" id="email_addr" name="email_addr" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>

 <label>Мобильный номер (с кодом оператора):</label>
 <input type="tel" id="mob_phone" name="mob_phone" pattern="[0-9]{9}" maxlength="9" required>
 
 <label>Адрес:</label>
 <input type="text" id="address" name="address" maxlength="50" required>

 <label>Логин:</label>
 <input type="text" id="reg_login" name="reg_login" maxlength="30" required>

 <label>Пароль:</label>
 <input type="password" id="reg_password" name="reg_password" maxlength="50" required>
 <br>

<input type="submit" value="Зарегистрироваться" />
</form>

<?php 
include_once ("footer.php");