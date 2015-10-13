<?php
session_start();
include_once ("../models/users.php");
include_once ("../views/functions.php");
if ($_SESSION['id_user']){
$user = new Users();
$user->getUser($_SESSION['id_user']);

$GLOBALS ['title'] = "Профиль";

include_once ("header.php");
?>
<h2>Ваши настройки</h2>
<form name="registration" action="http://localhost/iba/user/update" method="post" onsubmit="alert('Ваши данные успешно сохранены!');">

 <input type="hidden" id="id_user" name="id_user" value="<?php echo $user->id;?>">

 <label>Ваше имя:</label>
 <input type="text" id="name" name="name" maxlength="25" value="<?php echo $user->name;?>" required>

 <label>Фамилия:</label>
 <input type="text" id="surname" name="surname" maxlength="25" value="<?php echo $user->surname;?>" required>

 <label>Email:</label>
 <input type="email" id="email_addr" name="email_addr" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value="<?php echo $user->email;?>" required>

 <label>Мобильный номер (с кодом оператора):</label>
 <input type="tel" id="mob_phone" name="mob_phone" pattern="[0-9]{9}" maxlength="9" value="<?php echo $user->phone;?>" required>
 
 <label>Адрес:</label>
 <input type="text" id="address" name="address" maxlength="50" value="<?php echo $user->address;?>" required>

 <label>Логин:</label>
 <input type="text" id="reg_login" name="reg_login" maxlength="30" value="<?php echo $user->login;?>" required>

 <label>Пароль:</label>
 <input type="password" id="reg_password" name="reg_password" placeholder="Новый пароль" maxlength="50">
 <input type="hidden" id="md5_old_password" name="md5_old_password" value="<?php echo $user->password;?>">
 <br>

<input type="submit" value="Сохранить" />
</form>
<?php 
include_once ("footer.php");} else echo "<p>Вы не авторизированы</p>";
