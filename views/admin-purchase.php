<?php
include_once ("../core/model.php");
include_once ("../models/users.php");
include_once ("../models/goods.php");
include_once ("../models/purchase.php");
include_once ("../views/functions.php");

$id_purchase = getIdFromUrl ();

Purchase::getInstance ()->getPurchase($id_purchase);
$user = new Users();
$user->getUser(Purchase::getInstance()->id_user);
$good = new Goods();
$good->getGood(Purchase::getInstance()->id_good);

include_once ("admin-header.php");

echo "<a href='" . PATHSITE . "/admin-purchases'>Вернуться</a>"; // or href="javascript:history.go(-1)"
?>
<h2>Просмотр покупки</h2>
<form name="admin-purchase" action="http://localhost/iba/purchase/update" method="post" onsubmit="alert('Данные успешно сохранены!');">

 <label>Номер заказа:</label>
 <input type="text" id="purchase_id" name="purchase_id" maxlength="25" value="<?php echo Purchase::getInstance()->id;?>" readonly="readonly">

 <label>Товар:</label>
 <a href="<?php echo PATHSITE . "/good/" . $good->id; ?>"> <?php echo $good->name;?></a><br>
 
 <label>Количество:</label>
 <input type="text" id="good_count" name="good_count" maxlength="30" value="<?php echo Purchase::getInstance()->count;?>" readonly="readonly">
 
 <label>Сумма заказа:</label>
 <input type="text" id="cost_purchase" name="cost_purchase" maxlength="30" value="<?php echo Purchase::getInstance()->cost;?>" readonly="readonly">
 
 <label>Покупатель:</label>
 <input type="text" id="buyer" name="buyer" maxlength="50" value="<?php echo $user->surname . " " . $user->name;?>" readonly="readonly">

 <label>Email покупателя:</label>
 <input type="email" id="email_addr" name="email_addr" value="<?php echo $user->email;?>" readonly="readonly">

 <label>Мобильный номер покупателя:</label>
 <input type="tel" id="mob_phone" name="mob_phone" maxlength="9" value="<?php echo $user->phone;?>" readonly="readonly">
 
 <label>Адрес:</label>
 <input type="text" id="address" name="address" maxlength="50" value="<?php echo $user->address;?>" readonly="readonly">
 
 <label>Покупка оформлена?</label>
 <input type="checkbox" id="is_finished" name="is_finished" <?php if (Purchase::getInstance()) echo "checked='checked'"; ?>>

<input type="submit" value="Сохранить" />
</form>

<?php 
include_once ("footer.php");