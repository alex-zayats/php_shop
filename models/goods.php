<?php
require_once '../core/model.php';
include_once ("../views/functions.php");

$action = getIdFromUrl (); // with parameters
if (stripos ( $action, "?" ) !== FALSE)
	$action = substr ( $action, 0, stripos ( $action, "?" ) ); // without parameters
class Goods extends Model {
	public $id, $name, $price, $review, $size, $color, $img_link, $in_sale, $is_showed, $id_category;

	function getData() {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM goods';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			$result = $sth->fetchAll ();
			$dbh = null;
			return $result;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function getGood($id) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM goods WHERE id=:id';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam ( ':id', $id );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_INTO, $this );
			
			$sth->fetch ();
			
			// foreach ($result as $propName => $propValue)
			// {
			// $this->{$propName} = $propValue;
			// }
			
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function getGoodsFromCategories($id_category) {
		$id_category = implode ( ",", $id_category );
		
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM goods WHERE id_category IN (' . $id_category . ')';
			
			$sth = $dbh->prepare ( $zapros );
			
			// $sth->bindParam ( ':id_category', $id_category );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			$result = $sth->fetchAll ();
			
			$dbh = null;
			return $result;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function saveData($name, $price, $review, $size, $color, $img_link, $in_sale, $is_showed, $id_category) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'INSERT INTO goods (id, name, price, review, size, color, img_link, in_sale, is_showed, id_category) VALUES (null, :name, :price, :review, :size, :color, :img_link, :in_sale, :is_showed, :id_category)';
			$sth = $dbh->prepare ( $zapros );
			$data = array (
					'name' => $name,
					'price' => $price,
					'review' => $review,
					'size' => $size,
					'color' => $color,
					'img_link' => $img_link,
					'in_sale' => $in_sale,
					'is_showed' => $is_showed,
					'id_category' => $id_category 
			);
			
			$sth->execute ( $data );
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function getNameGood($id) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT name FROM goods WHERE id = :id';
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam ( ':id', $id );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			$result = $sth->fetch ();
			return $result ['name'];
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function updateGood($id, $name, $price, $review, $size, $color, $img_link, $in_sale, $is_showed, $id_category) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'UPDATE goods SET name = :name, price = :price, review = :review, size = :size, color = :color, img_link = :img_link, in_sale = :in_sale, is_showed = :is_showed, id_category = :id_category WHERE id = :id';
			$sth = $dbh->prepare ( $zapros );
			
			$data = array (
					'name' => $name,
					'price' => $price,
					'review' => $review,
					'size' => $size,
					'color' => $color,
					'img_link' => $img_link,
					'in_sale' => $in_sale,
					'is_showed' => $is_showed,
					'id_category' => $id_category,
					'id' => $id 
			);
			
			$sth->execute ( $data );
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
}
switch ($action) {
	case "add" :
		$good = new Goods ();
		if ($_FILES ["img_link"] ["name"] != '' & $_FILES ["img_link"] ["size"] < 1024 * 3 * 1024 & is_uploaded_file ( $_FILES ["img_link"] ["tmp_name"] )) {
			move_uploaded_file ( $_FILES ["img_link"] ["tmp_name"], PATHSAVE . $_FILES ["img_link"] ["name"] );
			$img_link = $_FILES ["img_link"] ["name"];
		} else $img_link='';
		if(isset($_POST['in_sale'])) $in_sale=1; else $in_sale=0;
		if(isset($_POST['is_showed'])) $is_showed=1; else $is_showed=0;
		$id_category = 0;
		$good->saveData($_POST ['name'], $_POST ['price'], htmlspecialchars ( $_POST ['review'] ), $_POST ['size'], $_POST ['color'], $img_link, $in_sale, $is_showed, $_POST['id_category'] );
		header ( "Location: " . PATHSITE . "/admin-goods" );
		break;
	case "remove" :
		$good = new Goods ();
		$good->deleteData("goods", $_POST['id_good']);
		header ( "Location: " . PATHSITE . "/admin-goods" );
		break;
	case "update" :
		$good = new Goods ();
		$good->getGood ( $_POST ['id_good'] );
		if ($_FILES ["img_link"] ["name"] != '' & $_FILES ["img_link"] ["size"] < 1024 * 3 * 1024 & is_uploaded_file ( $_FILES ["img_link"] ["tmp_name"] )) {
			move_uploaded_file ( $_FILES ["img_link"] ["tmp_name"], PATHSAVE . $_FILES ["img_link"] ["name"] );
			$img_link = $_FILES ["img_link"] ["name"];
		} else
			$img_link = $good->img_link;
		$good->updateGood ( $_POST ['id_good'], $_POST ['name'], $_POST ['price'], htmlspecialchars ( $_POST ['review'] ), $_POST ['size'], $_POST ['color'], $img_link, $_POST['in_sale'], $_POST['is_showed'], $_POST['id_category'] );
		header ( "Location: " . $_SERVER ['HTTP_REFERER'] );
		break;	
	default :
		break;
}