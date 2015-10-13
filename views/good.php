<?php
include_once ("../models/categories.php");
include_once ("../models/goods.php");
include_once ("functions.php");

$id_good = getIdFromUrl ();

$good = new Goods ();
$good->getGood ( $id_good );

$GLOBALS ['title'] = $good->name;

include_once ("header.php");

echo "<a href=" . $_SERVER ['HTTP_REFERER'] . ">Вернуться к просмотру товаров</a>"; // or href="javascript:history.go(-1)"
echo "<p><b>" . $good->name . "</b></p>";
echo "<p>" . $good->price . "</p>";
echo "<p>" . $good->size . "</p>";
echo "<p>" . $good->review . "</p>";

if ($good->in_sale == 1)
	echo "<p>Есть в продаже</p>";
else
	echo "<p>Нет в продаже</p>";

include_once ("footer.php");