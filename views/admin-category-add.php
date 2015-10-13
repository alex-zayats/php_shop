<?php
include_once ("../core/model.php");
include_once ("../models/categories.php");
include_once ("../views/functions.php");

$id_category = getIdFromUrl ();

$category = new Categories();

include_once ("admin-header.php");

echo "<a href='" . PATHSITE . "/admin-categories'>Вернуться</a>"; // or href="javascript:history.go(-1)"
?>
<h2>Создать категорию</h2>

<form name="admin-category" action="http://localhost/iba/category/add" method="post" onsubmit="alert('Данные успешно сохранены!');">

 <input type="hidden" id="id_parent" name="id_parent" value="<?php echo $id_category;?>">
 <label>Название категории:</label>
 <input type="text" id="name" name="name" maxlength="30">
 
 <input type="submit" value="Сохранить" />
</form>
<?php 
include_once ("footer.php");