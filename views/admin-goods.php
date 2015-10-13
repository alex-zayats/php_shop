<?php
session_start ();
include_once ("../core/model.php");
include_once ("../models/goods.php");
if (isset ( $_SESSION ['id_admin'] )) {
	include_once ("../views/admin-header.php");
	?>
<h2>Товары сайта</h2> 
<?php
echo "<button><a href='". PATHSITE ."/admin-good-add'>Добавить новый</a></button>";

	$good = new Goods ();
	$all_goods = $good->getData ();
	
	foreach ( $all_goods as $array => $each ) {
		echo "<p><a href='" . PATHSITE . "/admin-good/" . $each ['id'] . "'>" . $each ['name'] . "</a></p>";
	}
	
	include_once ("../views/footer.php");
} else
	header ( "Location:" . PATHSITE . "/user/login-admin" );