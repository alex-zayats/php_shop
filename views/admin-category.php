<?php
include_once ("../core/model.php");
include_once ("../models/categories.php");
include_once ("../views/functions.php");

$id_category = getIdFromUrl ();

$category = new Categories();
$category->getCategory($id_category);

include_once ("admin-header.php");

echo "<a href='" . PATHSITE . "/admin-categories'>Вернуться</a>"; // or href="javascript:history.go(-1)"
?>
<h2>Просмотр категории</h2>
<form name="admin-category" action="http://localhost/iba/category/update" method="post" onsubmit="alert('Данные успешно сохранены!');">

 <label>Номер категории:</label>
 <input type="text" id="id_category" name="id_category" maxlength="11" value="<?php echo $category->id;?>" readonly="readonly">

 <label>Название категории:</label>
 <input type="text" id="name" name="name" maxlength="30" value="<?php echo $category->name;?>">
 
 <label>Родительская категория:</label>
 <input type="text" id="id_parent" name="id_parent" maxlength="11" value="<?php echo $category->id_parent;?>">
 
 
 <input type="submit" value="Сохранить" />
</form>

<form name="admin-category" action="http://localhost/iba/category/remove" method="post">
 <input type="hidden" id="id_category" name="id_category" value="<?php echo $id_category;?>">
 <input type="submit" value="Удалить" />
</form>
<?php 
include_once ("footer.php");