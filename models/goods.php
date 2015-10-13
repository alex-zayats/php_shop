<?php
require_once '../core/model.php';
class Goods extends Model {
	public $id, $name, $price, $review, $size, $color, $img_link, $in_sale, $is_showed, $id_category;
	function newGood($id, $name, $price, $review, $size, $color, $img_link, $in_sale, $is_showed, $id_category) {
		if ($id == "")
			$this->id = null;
		else
			$this->id = $id;
		$this->price = $price;
		$this->review = $review;
		$this->size = $size;
		$this->color = $color;
		$this->img_link = $img_link;
		$this->id_category = $id_category;
		$this->in_sale = $in_sale;
		$this->is_showed = $is_showed;
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
			
			$result = $sth->fetch ();
			
			// foreach ($result as $propName => $propValue)
			// {
			// $this->{$propName} = $propValue;
			// }
			
			return $result;
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function getGoodsFromCategories($id_category) {
		
		$id_category = implode(",", $id_category);

		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM goods WHERE id_category IN ('.$id_category.')';
			
			$sth = $dbh->prepare ( $zapros );
			
			//$sth->bindParam ( ':id_category', $id_category );
			
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
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
		return $result ['name'];
	}
}