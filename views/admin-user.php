<?php
include_once ("../core/model.php");
include_once ("../models/users.php");
include_once ("../views/functions.php");

$id_user = getIdFromUrl ();

$user = new Users();
$user->getUser( $id_user );

include_once ("admin-header.php");

echo "<a href='" . PATHSITE . "/admin-users'>Вернуться</a>"; // or href="javascript:history.go(-1)"
?>
<h2>Настройки пользователя</h2>
<form name="admin-user" action="http://localhost/iba/user/update" method="post" onsubmit="alert('Данные успешно сохранены!');">

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
 
 <label>Админ?</label>
 <input type="checkbox" id="is_admin" name="is_admin" <?php if ($user->is_admin==1) echo "checked='checked'"; ?> value="1">
 
 <label>Пароль:</label>
 <input type="password" id="reg_password" name="reg_password" placeholder="Новый пароль" maxlength="50">
 <input type="hidden" id="md5_old_password" name="md5_old_password" value="<?php echo $user->password;?>">
 <br>

 <input type="submit" value="Сохранить" />
</form>

<form name="admin-user" action="http://localhost/iba/user/remove" method="post">
 <input type="hidden" id="id_user" name="id_user" value="<?php echo $user->id;?>">
 <input type="submit" value="Удалить" />
</form>

<?php 
include_once ("footer.php");
