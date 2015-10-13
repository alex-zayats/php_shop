<?php
// include_once ("../models/categories.php");
// include_once ("../models/goods.php");
// include_once ("../models/users.php");
DEFINE(PATHSITE, "http://localhost/iba");
function getIdFromUrl($id=3) {
	$routes = explode ( '/', $_SERVER ['REQUEST_URI'] );
	return $routes [$id];
}
function drawMenu($main_category, $category, $parent_path) {
	$each ['id'] = $main_category;
	echo "<ul class='category'>";
	$child_categories = $category->getChildCategories ( $each ['id'] );
	foreach ( $child_categories as $array => $each ) {
		echo "<li><a href='" . PATHSITE . "/category/" . $each ['id'] . "'>" . $each ['name'] . "</a></li>";
		if (in_array ( $each ['id'], $parent_path )) {
			drawMenu ( $each ['id'], $category, $parent_path );
		}
	}
	echo "</ul>";
}
function drawAllMenu($main_category, $category) {
	$each ['id'] = $main_category;
	echo "<ul class='category'>";
	$child_categories = $category->getChildCategories ( $each ['id'] );
	foreach ( $child_categories as $array => $each ) {
		echo "<li><a href='" . PATHSITE . "/admin-category/" . $each ['id'] . "'>" . $each ['name'] . "</a>";
		echo " <a href='" . PATHSITE . "/admin-category-add/".$each['id']."'><img src='" . PATHSITE . "/images/button_plus.png' width='20px' height='20px'></a></li>";
		drawAllMenu($each['id'], $category);
	}
	echo "</ul>";
}