<?php
include_once ("../models/categories.php");
include_once ("../models/goods.php");
include_once ("../models/users.php");
function getIdFromUrl() {
	$routes = explode ( '/', $_SERVER ['REQUEST_URI'] );
	return $routes [3];
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
?>