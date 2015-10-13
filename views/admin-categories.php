<?php
session_start ();
include_once ("../core/model.php");
include_once ("../models/categories.php");

if (isset ( $_SESSION ['id_admin'] )) {
	include_once ("../views/admin-header.php");
	?>
<h2>Категории на сайте</h2>
<div id="block-categories">
<?php
	$category = new Categories();
	$all_categories = $category->getData ();
	$parent_categories = array();

	foreach ( $all_categories as $array => $each ) {
		if ($each['id_parent']==NULL) array_push($parent_categories, $each);
	}
	
	foreach ( $parent_categories as $array => $each ) {
		echo "<ul class='admin-category'>";
		echo "<li><a href='" . PATHSITE . "/admin-category/" . $each ['id'] . "'>" . $each ['name'] . "</a>";
		echo " <a href='" . PATHSITE . "/admin-category-add/" . $each ['id'] . "'><img src='" . PATHSITE . "/images/button_plus.png' width='20px' height='20px'></a></li>";
		drawAllMenu($each['id'], $category);
		echo "</ul>";
	}
	
	echo "</div>";
	include_once ("../views/footer.php");
} else
	header ( "Location:" . PATHSITE . "/user/login-admin" );