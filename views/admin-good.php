<?php
include_once ("../core/model.php");
include_once ("../models/goods.php");
include_once ("../views/functions.php");

$id_good = getIdFromUrl ();

$good = new Goods();
$good->getGood($id_good);

include_once ("admin-header.php");

echo "<a href='" . PATHSITE . "/admin-goods'>Вернуться</a>"; // or href="javascript:history.go(-1)"
?>
<h2>Просмотр товара</h2>
<form name="admin-good" action="http://localhost/iba/good/update" method="post" enctype="multipart/form-data" onsubmit="alert('Данные успешно сохранены!');">

 <label>Номер товара:</label>
 <input type="text" id="id_good" name="id_good" maxlength="11" value="<?php echo $good->id;?>" readonly="readonly">

 <label>Товар:</label>
 <input type="text" id="name" name="name" maxlength="30" value="<?php echo $good->name;?>">
  
 <label>Цена:</label>
 <input type="text" id="price" name="price" maxlength="10" value="<?php echo $good->price;?>">
 
 <label>Доступные размеры:</label>
 <input type="text" id="size" name="size" maxlength="10" value="<?php echo $good->size;?>">
 
 <label>Цвет:</label>
 <input type="text" id="color" name="color" maxlength="20" value="<?php echo $good->color;?>">
 
 <label>Описание:</label><br>
 <textarea id="review" name="review" maxlength="300"><?php echo $good->review;?></textarea><br><br>
 
 <label>Изображение товара (до 3 Мб)</label>
 <input type="file" id="img_link" name="img_link" accept="image/jpeg,image/png,image/gif">
 
 <?php if ($good->img_link!="") {?>
 <img id="good_img" src="<?php echo PATHSITE . "/img/" . $good->img_link;?>" width="300px" height="300px"><br>
 <?php }?>
 
 <label>Категория:</label>
 <input type="text" id="id_category" name="id_category" maxlength="11" value="<?php echo $good->id_category;?>">
 
 <label>Отображать на сайте?</label>
 <input type="checkbox" id="is_showed" name="is_showed" <?php if ($good->is_showed==1) echo "checked='checked'"; ?> value="1">

 <label>Есть на складе?</label>
 <input type="checkbox" id="in_sale" name="in_sale" <?php if ($good->in_sale==1) echo "checked='checked'"; ?> value="1">
 
 <input type="submit" value="Сохранить" />
</form>

<form name="admin-good" action="http://localhost/iba/good/remove" method="post">
 <input type="hidden" id="id_good" name="id_good" value="<?php echo $good->id;?>">
 <input type="submit" value="Удалить" />
 <a href="<?php echo PATHSITE ."/good/". $good->id;?>">Посмотреть на сайте</a>
</form>
<?php 
include_once ("footer.php");