<?php
session_start ();
include_once ("../models/cart.php");
include_once ("../models/goods.php");
include_once ("../views/functions.php");

$GLOBALS ['title'] = "Корзина";

include_once ("header.php");
?>
<h2>Корзина</h2>

<?php
if (! isset ( $_SESSION ['id_user'] ))
	echo "<p>*Требуется войти, чтобы совершить покупку</p>"?>

<div>
<?php

$cart_goods = Cart::getInstance ()->getAllCookies ();
if (! empty ( $cart_goods )) {
	echo "<a href='http://localhost/iba/cart/removeAll'>Очистить корзину</a><br><br>";
	$good = new Goods ();
	foreach ( $cart_goods as $key => $value ) {
		$good->getGood ( $key );
		echo "<form action='" . PATHSITE . "/purchase/buy' method='post' oninput='cost.value=(price.valueAsNumber * count.valueAsNumber)'>";
		echo  "<a href='".PATHSITE."/good/".$key."'>".$good->name."</a> ";
		echo "<input name='id' type='number' hidden='true' value='$key'>";
		echo "<input name='count' type='number' min='1' step='1' required='true' value=$value> ";
		echo "<input name='price' type='number' hidden='true' value=$good->price>";
		echo "<input name='cost' type='number' min='1' readonly='true' required='true' value=$good->price> ";
		if (isset ( $_SESSION ['id_user'] ))
			echo "<input name='submitButton' type='submit' value='Купить'>  ";
		echo "<a href='" . PATHSITE . "/cart/remove?id=$key'>Удалить</a><br>";
		echo "</form>";
	}
} else {
	echo "<p>Вы пока ничего не добавили</p>";
}
?>
</div>

<?php

include_once ("footer.php");
