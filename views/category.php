<?php
include_once ("../models/categories.php");
include_once ("functions.php");

$id_category = getIdFromUrl ();

$category = new Categories ();
$GLOBALS ['title'] = $category->getNameCategory ( $id_category );

include_once ("header.php");
?>

<div id="sidebar">
<?php
$parent_path = $category->getParentPath($id_category);
$main_category = $parent_path[0];
$child_categories = $category->getAllChildCategories($id_category);
$main_child_categories = $category->getChildCategories ($main_category);

drawMenu($main_category, $category, $parent_path);
?>
</div>

<div id="content">

<?php
$good = new Goods ();
$all_goods = $good->getGoodsFromCategories ( $child_categories );

foreach ( $all_goods as $array => $each ) {
	echo "<p><a href='".PATHSITE."/good/".$each['id']."'>" . $each ['name'] . ", " . $each ['price'] . "</a></p>";
}
?>
</div>


<?php
include_once ("footer.php");