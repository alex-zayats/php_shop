<?php
session_start();
include_once ("../views/functions.php");
include_once ("../models/cart.php");

$action = getIdFromUrl (); // with parameters
if (stripos ( $action, "?" ) !== FALSE)
	$action = substr ( $action, 0, stripos ( $action, "?" ) ); // without parameters
class Purchase {
	protected static $instance;
	public $id, $id_good, $id_user, $data, $count, $cost;
	static function getInstance() {
		return (self::$instance === null) ? self::$instance = new self () : self::$instance;
	}
	function buy() {
		if (isset ( $_POST ['id'] ) & isset ( $_POST ['count'] ) & isset ( $_POST ['cost'] ) & Cart::getInstance()->IsCookie($_POST ['id'])) {
			try {
				//header("Location: ".$_SERVER['PHP_SELF']); //решаем проблему повторной отправки данных формы
				$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
				$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$zapros = 'INSERT INTO purchases (id, id_good, id_user, data, count, cost) VALUES (null, :id_good, :id_user, :data, :count, :cost)';
				$sth = $dbh->prepare ( $zapros );
				
				$data = array (
						'id_good' => $_POST ['id'],
						'id_user' => $_SESSION['id_user'],
						'data' => date ( "Y.n.j" ), // Год, месяц, день
						'count' => $_POST ['count'],
						'cost' => $_POST ['cost'] 
				);
				$sth->execute ( $data );
				$result = $dbh->lastInsertId();
				
				$dbh = null;
				Cart::getInstance ()->deleteCookie ($_POST ['id']); // или call_user_func(array('Cart', 'DeleteCookie'));
				
				return $result;
				
			} catch ( PDOException $e ) {
				echo "Error occurred! " . $e->getMessage ();
			}
		}
	}
	function getData() {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM purchases';
				
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
	function getPurchase($id) {
		try {
			$dbh = new PDO ( 'mysql:host=localhost;dbname=iba', USER, PASS );
			$dbh->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$zapros = 'SELECT * FROM purchases WHERE id=:id';
			
			$sth = $dbh->prepare ( $zapros );
			
			$sth->bindParam ( ':id', $id );
			
			$sth->execute ();
			
			$sth->setFetchMode ( PDO::FETCH_INTO, $this );
			
			$result = $sth->fetch ();
			
			return $result;
			$dbh = null;
		} catch ( PDOException $e ) {
			echo "Error occurred! " . $e->getMessage ();
		}
	}
}
