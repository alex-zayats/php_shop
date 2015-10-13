<?php
include_once ("../core/model.php");

include_once ("../models/categories.php");
include_once ("../models/goods.php");
include_once ("../views/functions.php");

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
	if ($each['is_showed']==1){
	echo "<div class='good'>";
	echo "<a href='".PATHSITE."/good/".$each['id']."'><p class='good-name'>" . $each ['name'] . "</p>";
	if ($each['img_link']=="") $each['img_link'] = "none-link.jpg";
	echo "<img class='good_img' src='". PATHSITE . "/img/" . $each['img_link'] ."' width='200px' height='200px'><br>";
	echo "<p>" . $each ['price'] . " руб.</p>";
	echo "</a></div>";
	}
}
?>
</div>


<?php
include_once ("footer.php");