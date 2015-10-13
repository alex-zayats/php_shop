<?php
session_start ();
include_once ("../core/model.php");
include_once ("../models/users.php");
if (isset ( $_SESSION ['id_admin'] )) {
	include_once ("../views/admin-header.php");
	?>
<h2>Пользователи сайта</h2>
<?php
echo "<button><a href='". PATHSITE ."/admin-user-add'>Добавить нового</a></button>";
	$user = new Users ();
	$all_users = $user->getData ();
	
	foreach ( $all_users as $array => $each ) {
		echo "<p><a href='" . PATHSITE . "/admin-user/" . $each ['id'] . "'>" . $each ['name'] . " " . $each ['surname'] . "</a></p>";
	}
	
	include_once ("../views/footer.php");
} else
	header ( "Location:" . PATHSITE . "/user/login-admin" );