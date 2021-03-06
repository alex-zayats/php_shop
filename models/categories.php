<?php
require_once '../core/model.php';
include_once ("../views/functions.php");

$action = getIdFromUrl (); // with parameters
if (stripos ( $action, "?" ) !== FALSE)
	$action = substr ( $action, 0, stripos ( $action, "?" ) ); // without parameters

class Categories extends Model {
	public $id, $name, $id_parent;
// 	function newCategory($id, $name, $id_parent) {
// 		if ($id == "")
// 			$this->id = null;
// 		else
// 			$this->id = $id;
// 		$this->name = $name;
// 		$this->id_parent = $id_parent;
// 	}
	function getData() {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM categories';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			$result = $sth->fetchAll ();
			
			$dbh = null;
			return $result;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function saveData($name, $id_parent) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'INSERT INTO categories (id, name, id_parent) VALUES (null, :name, :id_parent)';
			$sth = $dbh->prepare ( $zapros );
			
			$data = array (
					'name' => $name,
					'id_parent' => $id_parent 
			);
			
			$sth->execute ( $data );
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function getCategory($id) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM categories WHERE id=:id';
				
			$sth = $dbh->prepare ( $zapros );
				
			$sth->bindParam ( ':id', $id );
				
			$sth->execute ();
				
			$sth->setFetchMode ( PDO::FETCH_INTO, $this );
				
			$sth->fetch ();
				
			// foreach ($result as $propName => $propValue) //если не работает FETCH_INTO
			// {
			// $this->{$propName} = $propValue;
				// }
					
			$dbh = null;
			} catch ( PDOException $e ) {
				echo "Error occurred! " . $e->getMessage ();
			}
		}
	function updateCategory($id, $name, $id_parent) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'UPDATE categories SET name = :name, id_parent = :id_parent WHERE id = :id';
			$sth = $dbh->prepare ( $zapros );
				
			$data = array (
					'name' => $name,
					'id_parent' => $id_parent,
					'id' => $id
			);
				
			$sth->execute ( $data );
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred: " . $e->getMessage ();
		}
	}
	function getNameCategory($id) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT name FROM categories WHERE id = :id';
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam ( ':id', $id );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			$dbh = null;
			$result = $sth->fetch ();
			return $result ['name'];
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function getChildCategories($id) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM categories WHERE id_parent = :id ORDER BY name';
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam ( ':id', $id );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_ASSOC );
			
			$result = $sth->fetchAll ();
			
			$dbh = null;
			return $result;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
	function getAllChildCategories($id_category) {
		$categories = $this->getData ();
		$child_categories [] = $id_category;
		
		do {
			$flag = TRUE;
			$count = count ( $child_categories );
			for($i = 0; $i <= count ( $categories ); $i ++) {
				if (in_array ( $categories [$i] ['id_parent'], $child_categories )) {
					array_push ( $child_categories, $categories [$i] ['id'] );
					unset($categories [$i]);
					sort($categories);
				}
			}
			if (count ( $child_categories ) - $count  == 0) {
				$flag = FALSE;
			}
			//$child_categories = array_unique($child_categories);
			
		} while ( $flag == TRUE );
		
		return $child_categories;
	}
	function getParentPath($id) {
		$categories = $this->getData ();
		$parent_path [] = $id;
		
		for($i = 0; $i < count ( $categories ); $i ++) {
			if ($categories [$i] ['id'] == $id) {
				if ($categories [$i] ['id_parent'] == NULL) {
					break;
				} else {
					$id = $categories [$i] ['id_parent'];
					array_push ( $parent_path, $id );
					$i = 0;
				}
			}
		}
		$parent_path = array_reverse ( $parent_path );
		return $parent_path;
	}
}
switch ($action) {
	case "add" :
		$category = new Categories();
		$category->saveData($_POST['name'], $_POST['id_parent']);
		header ( "Location: " . PATHSITE . "/admin-categories" );
		break;
	case "remove" :
		$category = new Categories();
		$category->deleteData("categories", $_POST['id_category']);
		header ( "Location: " . PATHSITE . "/admin-categories" );
		break;
	case "update" :
		$category = new Categories();
		$category->updateCategory($_POST['id_category'], $_POST['name'], $_POST['id_parent']);
		header ( "Location: " . $_SERVER ['HTTP_REFERER'] );
		break;
	default :
		break;
}