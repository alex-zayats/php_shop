<?php
include_once ("../core/model.php");
include_once ("../models/categories.php");
include_once ("../models/goods.php");
include_once ("../views/functions.php");

$id_good = getIdFromUrl ();

$good = new Goods ();
$good->getGood ( $id_good );

$GLOBALS ['title'] = $good->name;

include_once ("header.php");

echo "<a href=" . $_SERVER ['HTTP_REFERER'] . ">Вернуться к просмотру</a>"; // or href="javascript:history.go(-1)"

echo "<br><label><b>Название:</b></label><br>";
echo "<p><b> $good->name </b></p>";
echo "<label><b>Цена:</b></label><br>";
echo "<p> $good->price </p>";
echo "<label><b>Размеры:</b></label><br>";
echo "<p> $good->size </p>";
echo "<label><b>Описание:</b></label><br>";
echo "<p> $good->review </p>";
if ($good->img_link!="") {?>
 <img id="good_img" src="<?php echo PATHSITE . "/img/" . $good->img_link;?>" width="300px" height="300px"><br>
<?php }

if ($good->in_sale == 1){
	echo "<button><a href = '".PATHSITE."/cart/add?id=$good->id&count=1'>Добавить в корзину</a></button>";
}
else
	echo "<p>Нет в продаже</p>";

include_once ("footer.php");