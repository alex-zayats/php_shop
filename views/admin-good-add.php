<?php
include_once ("../core/model.php");
include_once ("../models/goods.php");
include_once ("../views/functions.php");

include_once ("admin-header.php");

echo "<a href='" . PATHSITE . "/admin-goods'>Вернуться</a>"; // or href="javascript:history.go(-1)"
?>
<h2>Новый товар</h2>
<form name="admin-good" action="http://localhost/iba/good/add" method="post" enctype="multipart/form-data" onsubmit="alert('Данные успешно сохранены!');">

 <label>Товар:</label>
 <input type="text" id="name" name="name" maxlength="30">
  
 <label>Цена:</label>
 <input type="text" id="price" name="price" maxlength="10">
 
 <label>Доступные размеры:</label>
 <input type="text" id="size" name="size" maxlength="10">
 
 <label>Цвет:</label>
 <input type="text" id="color" name="color" maxlength="20">
 
 <label>Описание:</label><br>
 <textarea id="review" name="review" maxlength="300"></textarea><br><br>
 
 <label>Изображение товара (до 3 Мб)</label>
 <input type="file" id="img_link" name="img_link" accept="image/jpeg,image/png,image/gif">
 
 <label>Категория:</label>
 <input type="text" id="id_category" name="id_category" maxlength="4">
 
 
 <label>Отображать на сайте?</label>
 <input type="checkbox" id="is_showed" name="is_showed" value="1">

 <label>Есть на складе?</label>
 <input type="checkbox" id="in_sale" name="in_sale" value="1">
 
 <input type="submit" value="Сохранить" />
</form>

<?php 
include_once ("footer.php");