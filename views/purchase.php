<?php 
include_once ("../models/purchase.php");
include_once ("../models/goods.php");

$id_purchase = Purchase::getInstance ()->buy ();

Purchase::getInstance ()->getPurchase($id_purchase);

$good= new Goods();
$good->getGood(Purchase::getInstance()->id_good);

$GLOBALS ['title'] = "Покупка";
include_once ("header.php");
?>

<p><b>Покупка успешно завершена!</b></p>
 
<?php if (Purchase::getInstance()->id_good!=''){
 echo "<p>Ваш номер заказа:".$id_purchase;
?>
</p>
<p>Вы заказали
<?php 
 echo "<b>".$good->name.", ".Purchase::getInstance()->count." шт<br></b>";
 echo "Сумма заказа: ".Purchase::getInstance()->cost." руб.";
}?>
</p>
<p>Чуть позднее с Вами свяжется наш специалист для уточнения времени доставки.</p>
<p>*по указанному Вами телефону в настройках.</p>

<a href="http://localhost/iba/cart">Вернуться к корзине</a>

<?php 
include_once ("footer.php");

