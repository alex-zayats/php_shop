<?php
session_start ();
include_once ("../core/model.php");
include_once ("../models/purchase.php");
if (isset ( $_SESSION ['id_admin'] )) {
	include_once ("../views/admin-header.php");
	?>
<h2>Покупки на сайте</h2>
<?php
	$all_purchases = Purchase::getInstance ()->getData ();
	
	foreach ( $all_purchases as $array => $each ) {
		echo "<p><a href='" . PATHSITE . "/admin-purchase/" . $each ['id'] . "'> #" .$each['id'] .".  ". $each ['data'] . "</a></p>";
	}
	
	include_once ("../views/footer.php");
} else
	header ( "Location:" . PATHSITE . "/user/login-admin" );